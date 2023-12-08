<template>
    <div>
      <div class="card">
        <div class="card-header d-flex justify-content-between">
          <h3 class="table-title m-0">{{ title }}</h3>
          <div class="input-group input-group-sm w-auto">
              <button type="button" class="btn btn-primary" @click="showCreateModal">
                <b><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="mr-2 bi bi-plus-circle-fill" viewBox="0 0 16 16">
                    <path
                      d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                  </svg> Adicionar</b>
              </button>
          </div>
        </div>
        <div class="card-body table-responsive table-sm">
          <table id="example" class="w-100 table table-hover dataTableSimple table-striped">
            <thead>
              <tr>
                <th v-for="column in columns" :key="column">{{ column }}</th>
              </tr>
            </thead>
            <tbody>
                <tr v-for="row in rows" :key="row.id">
                    <td v-for="(value, key) in Object.values(row).slice(0,-1)" :key="value">{{value}}</td>
                    <td v-for="action in row.actions" :key="action">
                      <span v-if="action.includes('Edit')">
                        <button class="btn btn-primary" @click="showEditModal(row.id)">Edit</button>
                      </span>
                      <span v-else-if="action.includes('Delete')">
                        <button class="btn btn-danger" @click="showDeleteModal(row.id)">Delete</button>
                      </span>
                    </td>
                </tr>
            </tbody>
            <tfoot>
  
            </tfoot>
          </table>
          <div class="d-flex justify-content-sm-start mt-4">
          </div>
        </div>
      </div>
    </div>
</template>
<script>
import { stringifyQuery } from 'vue-router';

  export default {
    name: "Table",
    props: {
        title: {
            type: String,
            required: true
        },
        columns: {
            type: Array,
            required: false
        },
        rows: {
            type: Array,
            required: false
        },
        showCreateModal: {
            type: Function,
            required: false
        },
        deleteRow: {
            type: Function,
            required: false
        },
        showEditModal: {
            type: Function,
            required: false
        },
    },
    methods: {
        showCreateModal() {
            this.$emit("showCreateModal");
        },
        showDeleteModal(id) {
          this.$emit("showDeleteModal", id);
        },
        showEditModal(id) {
          this.$emit("showEditModal", id);
        },
    
    },
    mounted() {
      console.log("Component mounted.");
    }
};
  </script>
  
  