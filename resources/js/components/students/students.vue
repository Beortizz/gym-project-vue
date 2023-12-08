<template>
      <Table title="Lista de Estudantes" :columns="columns" :rows="rows" @showCreateModal="showCreateModal" @showEditModal="showEditModal" @showDeleteModal="showDeleteModal"></Table>
      <ModalForm title="Adicionar Estudante" @submit="createStudent" :isModalOpen="isCreateModalOpen" @closeModal="closeModal">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" v-model="name" required>
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" v-model="email" required>
            <label for="age">Idade</label>
            <input type="number" class="form-control" id="age" v-model="age" required>
            <label for="weight">Peso</label>
            <input type="number" class="form-control" id="weight" v-model="weight" required>
            <label for="height">Altura</label>
            <input type="number" class="form-control" id="height" v-model="height" required>
      </ModalForm>
      <ModalForm :id="currentEditId" title="Editar Estudante" @submit="editStudent" :isModalOpen="isEditModalOpen" @closeModal="closeModal">
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" v-model="name" required>
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" v-model="email" required>
            <label for="age">Idade</label>
            <input type="number" class="form-control" id="age" v-model="age" required>
            <label for="weight">Peso</label>
            <input type="number" class="form-control" id="weight" v-model="weight" required>
            <label for="height">Altura</label>
            <input type="number" class="form-control" id="height" v-model="height" required>
      </ModalForm>
</template>
<script>
import Table from "./../table.vue";
import ModalForm from "./../modalForm.vue";


import axios from "axios";

export default {
  components: {
    Table,
    ModalForm,
  },
  data() {
    return {
      columns: ["ID","Nome", "Email", "Idade", "Peso", "Altura"],
      rows: [],
      isCreateModalOpen: false,
      isEditModalOpen: false,
      currentEditId: 0,
    }
  },  
  mounted() {
    console.log("Component mounted.") 
    this.fetchStudents();
  },
  methods: {
    fetchStudents() {
      axios
        .get("/api/students")
        .then((response) => {
          this.rows = response.data.map((student) => {
            return {
              id: student.id,
              name: student.name,
              email: student.email,
              age: student.age,
              weight: student.weight,
              height: student.height,
              actions: 
              [
                'Edit',
                'Delete'
              ],
            
            };
          });
        })
        .catch(console.error);
    },
    createStudent() {
      axios
        .post("/api/students", {
          name: this.name,
          email: this.email,
          age: this.age,
          weight: this.weight,
          height: this.height,
        })
        .then((response) => {
          this.name = "";
          this.email = "";
          this.age = "";
          this.weight = "";
          this.height = "";
          this.fetchStudents();
          this.closeModal();
          this.$swal(
            'Adicionado!',
            'O estudante foi adicionado.',
            'success'
          )
        })
        .catch(console.error);
    },

    editStudent(id) {
      axios
        .put(`/api/students/${id}`, {
          name: this.name,
          email: this.email,
          age: this.age,
          weight: this.weight,
          height: this.height,
        })
        .then((response) => {
          this.name = "";
          this.email = "";
          this.age = "";
          this.weight = "";
          this.height = "";
          this.fetchStudents();
          this.closeModal();
          this.$swal(
            'Editado!',
            'O estudante foi editado.',
            'success'
          )
        })
        .catch(console.error);
    },

    deleteStudent(id) {
      axios
        .delete(`/api/students/${id}`)
        .then((response) => {
          this.fetchStudents();
        })
        .catch(console.error);
    },

    closeModal() {
      this.isCreateModalOpen = false;
      this.isEditModalOpen = false;
    },

    showCreateModal() {
      this.name = "";
      this.email = "";
      this.age = "";
      this.weight = "";
      this.height = "";
      this.isCreateModalOpen = true;
    },

    showEditModal(id) {
      const student = this.rows.find(student => student.id === id);
      this.name = student.name;
      this.email = student.email;
      this.age = student.age;
      this.weight = student.weight;
      this.height = student.height;
      this.currentEditId = id;
      this.isEditModalOpen = true;
    },

    showDeleteModal(id) {
     this.$swal(
        {
          title: 'Tem certeza?',
          text: "Você não poderá reverter isso!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
        }
      ).then((result) => {
        if (result.isConfirmed) {
          this.deleteStudent(id);
          this.$swal(
            'Deletado!',
            'O estudante foi deletado.',
            'success'
          )
        }
      }
     )
       
    },
    
  }
};
</script>

