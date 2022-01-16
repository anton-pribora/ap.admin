    <div class="card-footer d-flex justify-content-between py-1">
      <div class="row row-cols-lg-auto g-3 align-items-center">
        <div class="col-12">
          <span class="">Показано {{filtered.length}} из {{list.length}}</span>
        </div>
      </div>

      <form class="row row-cols-lg-auto g-3 align-items-center">
        <div class="col-12">
          <span class="">Показывать на странице</span>
        </div>

        <div class="col-12">
          <select class="form-select form-select-sm" v-model="pager.limit">
            <option selected>15</option>
            <option>25</option>
            <option>50</option>
            <option>999</option>
          </select>
        </div>

        <div class="col-12">
          <span class="">Страница</span>
        </div>

        <div class="col-12">
          <div class="btn-group btn-group-sm">
            <button class="btn btn-default" :disabled="pager.page <= 0" @click.prevent="pager.page -= 1">&lt;&lt;</button>
          </div>
          <div class="btn-group mx-1">
            <select class="form-select form-select-sm btn-default" v-model="pager.page">
              <option v-for="e in pages" :value="e">{{e + 1}}</option>
            </select>
          </div>
          <div class="btn-group btn-group-sm">
            <button class="btn btn-default" :disabled="pager.page >= pages.length - 1" @click.prevent="pager.page += 1">&gt;&gt;</button>
          </div>
        </div>
      </form>
    </div>
