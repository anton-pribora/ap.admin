const toasts = function () {
  const container = document.getElementById('toastContainer');
  const toastTemplate = document.getElementById('toastTemplate').innerText.trim();

  const createToast = ({text, textColor, bgColor, escape}) => {
    const data = toastTemplate
      .replaceAll('{{text}}', escape ? text.replaceAll('&', '&amp;').replaceAll('<', '&lt;') : text)
      .replaceAll('{{textColor}}', textColor || 'white')
      .replaceAll('{{bgColor}}', bgColor || 'primary')
    ;

    container.insertAdjacentHTML('beforeend', data);

    const el = document.querySelector('#toastContainer .toast:last-child');
    const toast = new bootstrap.Toast(el);

    el.addEventListener('hidden.bs.toast', function () {
      container.removeChild(el);
    });
    toast.show();
  }

  const funcs = {
    success(text, escape = true) { createToast({text, escape, bgColor: 'success', textColor: 'white'}); },
    info(text, escape = true) { createToast({text, escape, bgColor: 'info', textColor: 'white'}); },
    danger(text, escape = true) { createToast({text, escape, bgColor: 'danger', textColor: 'white'}); },
    warning(text, escape = true) { createToast({text, escape, bgColor: 'warning', textColor: 'black'}); },
    primary(text, escape = true) { createToast({text, escape, bgColor: 'primary', textColor: 'white'}); },
    secondary(text, escape = true) { createToast({text, escape, bgColor: 'secondary', textColor: 'black'}); },
  }

  return {
    install: app => {
      app.config.globalProperties.$toast = funcs
    }
  }
}();

app.use(toasts);
