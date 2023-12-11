<template>
    <Table title="Lista de Exercícios" :columns="columns" @showCreateModal="showCreateModal">
        <tr v-for="row in rows" :key="row.id">
            <td v-for="(value, key) in Object.values(row).slice(0,-1)" :key="value">{{value}}</td>
            <td v-for="action in row.actions" :key="action">
              <span v-if="action.includes('Edit Row')">
                <button class="btn btn-primary" @click="showEditModal(row.id)">Edit</button>
              </span>
              <span v-else-if="action.includes('Delete Row')">
                <button class="btn btn-danger" @click="showDeleteModal(row.id)">Delete</button>
              </span>
            </td>
        </tr>
    </Table>
    <ModalForm title="Adicionar Exercício" @submit="createExercise" :isModalOpen="isCreateModalOpen" @closeModal="closeModal">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" v-model="name" required>
        <label for="muscleGroup">Grupo Muscular</label>
        <input type="text" class="form-control" id="muscleGroup" v-model="muscleGroup" required>
    </ModalForm>
    <ModalForm :id="currentEditId" title="Editar Exercício" @submit="editExercise" :isModalOpen="isEditModalOpen" @closeModal="closeModal">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" v-model="name" required>
        <label for="muscleGroup">Grupo Muscular</label>
        <input type="text" class="form-control" id="muscleGroup" v-model="muscleGroup" required>
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
        columns: ["ID", "Nome", "Grupo Muscular"],
        rows: [],
        isCreateModalOpen: false,
        isEditModalOpen: false,
        currentEditId: 0,
    }
  },
  mounted() {
    console.log("Component mounted.") 
    this.fetchExercises();
  },
  methods: {
    fetchExercises() {
        axios
            .get("/api/exercises")
            .then((response) => {
                this.rows = response.data.map((exercise)  => {
                    return {
                        id: exercise.id,
                        name: exercise.name,
                        muscleGroup: exercise.muscleGroup,
                        actions:[
                            'Edit',
                            'Delete'
                        ],
                    };
                }); 
            })
            .catch((error) => {
                console.log(error);
            });
    },

    createExercise() {
        axios
            .post("/api/exercises", {
                name: this.name,
                muscleGroup: this.muscleGroup,
            })
            .then((response) => {
                this.fetchExercises();
                this.closeModal();
                this.$swal.fire(
                    'Adicionado!',
                    'Exercício adicionado com sucesso!',
                    'success'
                )
            })
            .catch((error) => {
                console.log(error);
            });
    },

    editExercise(id) {
        axios
            .put(`/api/exercises/${id}`, {
                name: this.name,
                muscleGroup: this.muscleGroup,
            })
            .then((response) => {
                this.fetchExercises();
                this.closeModal();
                this.$swal.fire(
                    'Editado!',
                    'Exercício editado com sucesso!',
                    'success'
                )
            })
            .catch((error) => {
                console.log(error);
            });
    },
    deleteExercise(id) {
        axios
            .delete(`/api/exercises/${id}`)
            .then((response) => {
                this.fetchExercises();
                this.$swal.fire(
                    'Deletado!',
                    'Exercício deletado com sucesso!',
                    'success'
                )
            })
            .catch((error) => {
                console.log(error);
            });
    },
    closeModal() {
        this.isCreateModalOpen = false;
        this.isEditModalOpen = false;
    },

    showCreateModal() {
        this.name = "";
        this.muscleGroup = "";
        this.isCreateModalOpen = true;
    },

    showEditModal(id) {
        const exercise = this.rows.find(exercise => exercise.id === id);
        this.name = exercise.name;
        this.muscleGroup = exercise.muscleGroup;
        this.currentEditId = id;
        this.isEditModalOpen = true;
    },

    showDeleteModal(id) {
        this.$swal(
            {
                title: 'Você tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }
        ).then((result) => {
            if (result.isConfirmed) {
                this.deleteStudent(id);
            }
        })
    },

  }
}
</script>