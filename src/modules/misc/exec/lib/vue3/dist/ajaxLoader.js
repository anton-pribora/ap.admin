const ajaxLoader = {
  install(app) {
    const q = ({url = '', method = 'GET', body = undefined, headers = {}}) => fetch(url, {
        method,
        cache: 'no-cache',
        headers,
        body
      })
        // Ошибки уровня HTTP
        .then(async response => {
          if (!response.ok) {
            const text = await response.text();
            throw new Error(text || response.statusText);
          }
          return response;
        })
        // Парсим JSON
        .then(response => response.json())
        // Ошибки уровня пользователя
        .then(data => {
          if (data.error) {
            throw new Error(`${data.error.code}: ${data.error.description}`);
          }
          return data;
        })
        .catch(error => {
          app.config.globalProperties.$toast.danger(`Ошибка: ${error.message}`);
          app.config.globalProperties.$ajaxLoaderLastError = error;
        });

    app.config.globalProperties.$do = (action = '', data = {}) => q({
      method: 'POST',
      body: JSON.stringify({
        widget_action: action,
        widget_data: data
      }),
      headers: {
        'Content-Type': 'application/json',
        Accept: 'application/json'
      }
    });

    app.config.globalProperties.$get = (url, params = null) => q({
      url: params && `${url}?${new URLSearchParams(params).toString()}` || url,
      headers: {
        Accept: 'application/json'
      }
    });

    app.config.globalProperties.$postFormData = (url, formData) => q({
      url,
      method: 'POST',
      body: formData,
      headers: {
        Accept: 'application/json'
      }
    });

    app.config.globalProperties.$post = (url, data, multipart = false) => {
      function appendFormdata(FormData, data, name) {
        name = name || ''
        if (typeof data === 'object') {
          for (const [index, value] of Object.entries(data)) {
            if (name === '') {
              appendFormdata(FormData, value, index)
            } else {
              appendFormdata(FormData, value, name + '['+index+']')
            }
          }
        } else {
          FormData.append(name, data)
        }
      }

      const formData = multipart ? new FormData() : new URLSearchParams()
      appendFormdata(formData, data)

      return app.config.globalProperties.$postFormData(url, formData)
    }

    app.config.globalProperties.$delay = (promise, msec = 500) => {
      return Promise.all([
        promise,
        new Promise(resolve => setTimeout(resolve, msec))
      ]).then(results => results[0], results => results[0])
    }
  }
};

app.use(ajaxLoader);
