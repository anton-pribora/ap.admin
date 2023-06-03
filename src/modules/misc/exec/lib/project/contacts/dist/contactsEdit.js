app.component('contacts-edit', {
  template: `
    <div v-if="list && !list.length">
      <button type="button" class="btn btn-default" @click="addAfter(e)"><i class="bi bi-plus-lg me-1"></i>Добавить контакт</button>
    </div>
    <div class="row mb-1" v-for="(e,i) in list">
      <div class="col">
        <div class="input-group">
          <div class="input-group-text" title="Основной контакт">
            <input class="form-check-input mt-0" type="checkbox" v-model="e.primary">
          </div>
          <select class="form-select" style="max-width: 120px" v-model="e.type">
            <option value="phone">Телефон</option>
            <option value="skype">Скайп</option>
            <option value="email">Почта</option>
            <option value="mattermost">Mattermost</option>
          </select>
          <input class="form-control" placeholder="Значение" v-model="e.value">
          <input class="form-control" placeholder="Комментарий" v-model="e.comment">
          <button type="button" title="Добавить контакт" @click="addAfter(e)" class="btn btn-default px-1"><i class="bi bi-plus-lg"></i></button>
          <button type="button" title="Удалить контакт" @click="remove(e)" class="btn btn-default px-1"><i class="bi bi-trash"></i></button>
          <button type="button" title="Переместить вверх" @click="moveUp(e)" class="btn btn-default px-1"><i class="bi bi-arrow-up"></i></button>
        </div>
      </div>
    </div>
  `,
  props: ['list'],
  emits: ['change'],
  methods: {
    addAfter(e) {
      const emptyContact = {type: 'phone'}

      if (e) {
        this.list.splice(this.list.findIndex(i => e === i) + 1, 0, emptyContact)
      } else {
        this.list.push(emptyContact);
      }

      this.$emit('change');
    },
    remove(e) {
      this.list.splice(this.list.findIndex(i => e === i), 1);
      this.$emit('change');
    },
    moveUp(e) {
      const index = this.list.findIndex(i => e === i)
      const next = index - 1

      if (this.list[next]) {
        this.list.splice(next, 2, e, this.list[next])
        this.$emit('change');
      }
    }
  }
})
