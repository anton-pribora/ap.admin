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
      method: 'POST',
      body: formData,
      headers: {
        Accept: 'application/json'
      }
    });
  }
};

app.use(ajaxLoader);