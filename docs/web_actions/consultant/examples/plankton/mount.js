store.state.planktonUsers.list = [
  {id: 1, officeId: 1, name: 'Иванов Иван Иванович', date: '10.10.2022'},
  {id: 2, officeId: 2, name: 'Петров Пётр Петрович', date: '10.10.2022'},
];

store.state.planktonOffices.list = [
  {id: 1, name: 'Чистый пруд', address: 'Набережная, 25'},
  {id: 2, name: 'Городское водохранилище', address: 'Озёрская, 78'},
];

app.mount('#content');
