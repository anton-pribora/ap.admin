app.component('contacts-view', {
  template: `
    <ol class="list-unstyled mb-0">
      <li v-for="i in list">
        <i :class="icon(i.type)" class="me-1"></i>{{i.value}}
        <span v-if="i.primary && !i.comment" class="text-body-secondary">&mdash; основной контакт</span>
        <span v-if="!i.primary && i.comment" class="text-body-secondary">&mdash; {{i.comment}}</span>
        <span v-if="i.primary && i.comment" class="text-body-secondary">&mdash; основной контакт, {{i.comment}}</span>
      </li>
    </ol>
  `,
  props: ['list'],
  methods: {
    icon(type) {
      const icons = {
        email: 'bi bi-envelope',
        phone: 'bi bi-telephone',
        skype: 'bi bi-skype text-secondary',
        mattermost: 'bi bi-chat-right-text',
        default: 'bi bi-chat'
      };

      return icons[type] || icons.default;
    }
  }
})
