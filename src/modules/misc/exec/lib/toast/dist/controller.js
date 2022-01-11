const toasts = function () {
  const container = document.getElementById('toastContainer');
  const toastTemplate = document.getElementById('toastTemplate').innerText;

  const createToast = ({text, textColor, bgColor}) => {
    const data = toastTemplate
      .replaceAll('{{text}}', text)
      .replaceAll('{{textColor}}', textColor || 'white')
      .replaceAll('{{bgColor}}', bgColor || 'primary')
    ;

    container.insertAdjacentHTML('beforeend', data);

    const el = container.lastChild.previousSibling;
    const toast = new bootstrap.Toast(container.lastChild.previousSibling);

    el.addEventListener('hidden.bs.toast', function () {
      container.removeChild(el);
    })
    toast.show();
  }

  const funcs = {
    success(text) { createToast({text, bgColor: 'success', textColor: 'white'}); },
    info(text) { createToast({text, bgColor: 'info', textColor: 'white'}); },
    danger(text) { createToast({text, bgColor: 'danger', textColor: 'white'}); },
    warning(text) { createToast({text, bgColor: 'warning', textColor: 'black'}); },
    primary(text) { createToast({text, bgColor: 'primary', textColor: 'white'}); },
    secondary(text) { createToast({text, bgColor: 'secondary', textColor: 'black'}); },
  }

  return {
    install: app => {
      app.config.globalProperties.$toast = funcs
    }
  }
}();

app.use(toasts);
