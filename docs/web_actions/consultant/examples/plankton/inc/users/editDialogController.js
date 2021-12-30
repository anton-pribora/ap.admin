app.component('plankton-users-edit-dialog', {
  template: '#planktonUsersEditDialog',
  data() {
    return {
      user: {},
      loading: false,
    }
  },
  computed: {
    offices() {
      return this.$store.state.planktonOffices.list;
    }
  },
  methods: {
    show(e) {
      this.user = {...e}
      this._dirty = undefined;

      return new Promise((resolve) => {
        this.resolve = resolve;
        this.modal.show();
      })
    },
    async save() {
      this.modal._config.backdrop = 'static';
      this.loading = true;

      this.result = await this.$do('foo::save', this.user);

      this.loading = false;
      this.modal._config.backdrop = true;

      if (this.result) {
        this._dirty = undefined;
        this.modal.hide();
      }
    },
    onChange() {
      this._dirty = true;
    }
  },
  mounted() {
    this.modal = new bootstrap.Modal(this.$refs.modal);

    this.$refs.modal.addEventListener('hide.bs.modal', e => {
      if (this._dirty) {
        if (!confirm('Некоторые данные были изменены, вы действительно хотите закрыть форму и отменить изменения?')) {
          return e.preventDefault();
        }
      }
    })

    this.$refs.modal.addEventListener('hidden.bs.modal', e => {
      if (this.resolve) {
        this.resolve(this.result);

        this.resolve = undefined;
        this.result = undefined;
      }
    });

    this.$externalMethods.set('plankton-user-edit()', this.show);
  }
})
