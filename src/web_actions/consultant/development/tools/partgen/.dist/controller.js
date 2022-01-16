app.component('partgen', {
  template: '#partgenForm',
  props: {
    disableZip: Boolean,
    disableHdd: Boolean,
  },
  data() {
    return {
      part: {
        table: '',
        name: '',
        key: '',
        billet: '',
        repository: '',
        recordIdKey: '',
        path: '',
      },
      widget: {
        path: '',
      },
      permissions: {
        path: '',
      },
      generate: {
        classes: true,
        permissions: true,
        widget: true,
        section: true,
      },
      tables: [],
      tablesLoading: false,
      fields: [],
      fieldsLoading: false,
      showForm: false,
      result: '',
      resultIsLoading: false,
    }
  },
  methods: {
    async loadTables() {
      this.tablesLoading = true;
      const tables = await this.$get('tables.php');
      this.tablesLoading = false;

      if (tables) {
        this.tables = tables;
        this.part.table = '';
      }
    },
    async loadFields() {
      if (Boolean(this.part.table)) {
        this.fieldsLoading = true;
        this.fields = [];
        const fields = await this.$get('fields.php', {table: this.part.table});
        this.fieldsLoading = false;

        this.fields = fields || [];
      } else {
        this.fields = [];
      }
    },
    async generateFiles() {
      const fd = new FormData(this.$refs.form);
      fd.append('action', 'generate');

      this.resultIsLoading = true;

      const [result] = await Promise.all([
        this.$postFormData('', fd),
        new Promise(resolve => setTimeout(resolve, 600)),
      ]);

      this.resultIsLoading = false;
      this.result = result ? result.result : '';
    }
  },
  mounted() {
    this.loadTables();

    const ucfirst = s => s.replace(/^[a-z]/, m => m.toUpperCase());
    const lcfirst = s => s.replace(/^[A-Z]/, m => m.toLowerCase());
    const UpperCamelCase = s => ucfirst(s).replace(/[_-](\w)/g, (_, a) => a.toUpperCase());
    const LowerCamelCase = s => lcfirst(s).replace(/[_-](\w)/g, (_, a) => a.toUpperCase());
    const CamelCaseSplit  = s => s.replace(/([a-z])([A-Z])/g, (_, a, b) => a + ' ' + b);
    const CamelCaseToSnake = s => s.replace(/([a-z])([A-Z])/g, (_, a, b) => a + '_' + b).toLowerCase();
    const replaceDot = (s, r) => s.replace(/\./g, r);
    const fixDotInClassName = s => s.replace(/\.(\w)/g, (_, a) => `\\${a.toUpperCase()}`).replace(/\./g, '\\');

    this.$watch('part.table', n => {
      this.showForm = Boolean(n);
      this.part.key = LowerCamelCase(n);
      this.part.name = CamelCaseSplit(UpperCamelCase(n));
      this.loadFields();
    });

    this.$watch('part.key', n => {
      this.part.path = `@consultant/${replaceDot(n, '/')}`;
      this.part.billet = `Project\\${fixDotInClassName(UpperCamelCase(n))}`;
      this.part.recordIdKey = `${CamelCaseToSnake(n.replace(/.+\./, ''))}_id`;
      this.widget.path = n;
      this.permissions.path = `consultant.${n}`;
    });

    this.$watch('part.billet', n => {
      this.part.repository = `${n}Repository`;
    });
  }
});
