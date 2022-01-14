const uploadFilesDialog = Vue.createApp({
  data() {
    return {
      list: [],
      activeUploads: 0,
      successUploads: 0,
      errorUploads: 0,
      multiple: true,
      accept: '*/*',
      after: undefined,

      url: '',
      params: {},
    }
  },
  methods: {
    reset() {
      this.$refs.form.reset();
      this.list = [];
      this.successUploads = 0;
      this.errorUploads = 0;
      this.activeUploads = 0;
      this.after = undefined;
    },

    pickAndUploadFiles({
      url = '',               // Адрес, куда отправлять файлы
      action = undefined,  // Действие виджета
      data = undefined,    // Дополнительнительные данные для виджета
      after = undefined,   // Действие после загрузки файлов
      postParams = {},           // Дополнительные POST-параметры
      multiple = true,      // Признак множественного выбора файлов для загрузки
      accept = '*/*'          // Тип выбираемых файлов
    }) {
      if (action) {
        postParams['widget_action'] = action;
      }

      if (data) {
        postParams['widget_data'] = data;
      }

      this.url = url;
      this.params = postParams;
      this.multiple = multiple;
      this.accept = accept;
      this.after = after;

      this.$nextTick(() => {
        this.$refs.picker.click();
      });
    },

    uploadFiles(files, {
      url = '',               // Адрес, куда отправлять файлы
      action = undefined,  // Действие виджета
      data = undefined,    // Дополнительнительные данные для виджета
      after = undefined,   // Действие после загрузки файлов
      postParams = {},           // Дополнительные POST-параметры
    }) {
      if (action) {
        postParams['widget_action'] = action;
      }

      if (data) {
        postParams['widget_data'] = data;
      }

      this.reset();
      this.after = after;

      this.$nextTick(() => {
        this.modal.show();

        const params = JSON.parse(JSON.stringify(postParams));

        for(const file of files) {
          this.sendFile(file, url, params);
        }
      });
    },

    onChange(e) {
      this.modal.show();

      const params = JSON.parse(JSON.stringify(this.params));

      for(const file of e.target.files) {
        this.sendFile(file, this.url, params);
      }
    },

    sendFile(file, url = '', additionalData = {}) {
      function toFormData(obj, form, namespace) {
        const fd = form || new FormData();
        let formKey;

        for(let property in obj) {
          if (obj.hasOwnProperty(property) && obj[property] != null && obj[property] !== undefined) {
            if (namespace) {
              formKey = namespace + '[' + property + ']';
            } else {
              formKey = property;
            }

            // if the property is an object, but not a File, use recursive.
            if (obj[property] instanceof Date) {
              fd.append(formKey, obj[property].toISOString());
            }
            else if (typeof obj[property] === 'object' && !(obj[property] instanceof File)) {
              toFormData(obj[property], fd, formKey);
            } else { // if it's a string or a File object
              fd.append(formKey, obj[property]);
            }
          }
        }

        return fd;
      }

      this.list.push({progress: 0, done: false, name: file.name, success: false, error: false});

      const i   = this.list.length - 1;
      const xhr = new XMLHttpRequest();
      const fd  = toFormData(additionalData);

      xhr.upload.addEventListener("progress", e => {
          if (e.lengthComputable) {
              this.list[i].progress = Math.round((e.loaded * 100) / e.total);
          }
      });

      xhr.upload.addEventListener("load", e => {
        this.list[i].progress = 100;
      });

      xhr.onreadystatechange = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
          const status = xhr.status;
          this.activeUploads -= 1;
          this.list[i].done = true;

          try {
            // Пробуем разобрать ответ как JSON
            const json = JSON.parse(xhr.response);

            if (json.error) {
              this.list[i].error = `Ошибка: ${json.error.description || json.error}`;
              this.errorUploads += 1;
            } else {
              this.list[i].success = true;
              this.successUploads += 1;
            }
          } catch (e) {
            // Похоже ответ не JSON, а нужен JSON!
            if (status === 0 || (status >= 200 && status < 400)) {
              this.list[i].error = e.message;
            } else {
              this.list[i].error = `${xhr.status} ${xhr.statusText}`;
            }

            this.errorUploads += 1;
          }

          // Если активных загрузок нет и ошибок нет, автоматически закрываем диалог
          if (this.activeUploads === 0 && this.errorUploads === 0) {
            setTimeout(() => this.modal.hide(), 600);
          }
        }
      };

      fd.append('file', file);

      xhr.open("POST", url, true);
      xhr.send(fd);

      this.activeUploads += 1;
    }
  },
  mounted() {
    this.modal = new bootstrap.Modal(this.$refs.modal);

    this.$refs.modal.addEventListener('hide.bs.modal', e => {
      if (this.after) {
        this.after(this.successUploads > 0, this.errorUploads > 0);
      }
      this.reset();
    });

    this.$externalMethods.set('pickAndUploadFiles', this.pickAndUploadFiles);
    this.$externalMethods.set('uploadFiles', this.uploadFiles);
  },
});

uploadFilesDialog.use(externalMethods);
uploadFilesDialog.mount('#uploadFilesDialog');

app.use({
  install: app => {
    app.config.globalProperties.$pickAndUploadFiles = (options = {}) => externalMethods.call('pickAndUploadFiles', options);
    app.config.globalProperties.$uploadFiles = (files, options = {}) => externalMethods.call('uploadFiles', files, options);
  }
});

app.component('file-dropzone', {
  template: '<div :class="[className, classes]" @dragover.stop.prevent="" @dragenter.prevent="enter" @dragleave="leave" @drop.stop.prevent="drop"><slot></slot></div>',
  data() {
    return {
      classes: '',
      counter: 0,
    };
  },
  props: ['className'],
  emits: ['drop'],
  methods: {
    enter(e) {
      this.counter += 1;

      if (this.counter === 1) {
        this.classes = 'bg-light';
      }
    },
    leave(e) {
      if (this.counter > 0) {
        this.counter -= 1;
      }

      if (this.counter === 0) {
        this.classes = '';
      }
    },
    drop(e) {
      this.counter = 0;
      this.classes = '';

      if (e.dataTransfer.files.length) {
        this.$emit('drop', e.dataTransfer.files);
      }
    }
  }
});
