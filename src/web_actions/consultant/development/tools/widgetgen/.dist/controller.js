app.component('widgetgen', {
  template: '#widgetgenForm',
  props: {
    disableZip: Boolean,
    disableHdd: Boolean,
  },
  data() {
    return {
      part: {
        key: 'employee',
        billet: 'Project\\Employee',
        repository: 'Project\\EmployeeRepository',
      },
      widget: {
        name: 'myWidget',
        path: 'employee',
        template: '',
      },
      result: '',
      resultIsLoading: false,
    };
  },
  computed: {
    formIsInvalid() {
      return [this.widget.template, this.widget.path, this.widget.name].includes('');
    }
  },
  methods: {
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
    const ucfirst = s => s.replace(/^[a-z]/, m => m.toUpperCase());
    const UpperCamelCase = s => ucfirst(s).replace(/[_-](\w)/g, (_, a) => a.toUpperCase());
    const CamelCaseToSnake = s => s.replace(/([a-z])([A-Z])/g, (_, a, b) => a + '_' + b).toLowerCase();
    const fixDotInClassName = s => s.replace(/\.(\w)/g, (_, a) => `\\${a.toUpperCase()}`).replace(/\./g, '\\');

    this.$watch('part.key', n => {
      this.part.billet = `Project\\${fixDotInClassName(UpperCamelCase(n))}`;
      this.part.recordIdKey = `${CamelCaseToSnake(n.replace(/.+\./, ''))}_id`;
      this.widget.path = n;
    });

    this.$watch('part.billet', n => {
      this.part.repository = `${n}Repository`;
    });
  }
});
