<template>
    <PageStructure>
        <Table title="Lista de Exercícios" :columns="columns" @showCreateModal="showExerciseModal">
            <tr v-for="row in rows" :key="row.id">
                <td v-for="(value, key) in Object.values(row).slice(0, -1)" :key="value">{{ value }}</td>
                <td v-for="action in row.actions" :key="action">
                    <span v-if="action.includes('Edit')">
                        <button class="btn btn-primary" @click="showExerciseModal(row.id)">Edit</button>
                    </span>
                    <span v-else-if="action.includes('Delete')">
                        <button class="btn btn-danger" @click="showDeleteExerciseModal(row.id)">Delete</button>
                    </span>
                </td>
            </tr>
        </Table>
        <ModalForm title="Exercício" @submit="handleSubmitExercise(this.isExerciseModalOpen)" @closeModal="closeModal"
            :isModalOpen="isExerciseModalOpen || typeof isExerciseModalOpen === 'true'">
            <template v-slot:body>
                <label for="name">Nome</label>
                <input type="text" class="form-control" id="name" v-model="name" required>
                <label for="muscleGroup">Grupo Muscular</label>
                <input type="text" class="form-control" id="muscleGroup" v-model="muscleGroup" required>
            </template>
            <template v-slot:footer>
                <button type="button" class="btn btn-secondary" @click="closeModal">Fechar</button>
                <button type="submit" class="btn btn-primary">Salvar</button>
            </template>
        </ModalForm>
    </PageStructure>
</template>

<script>
import Table from "./../table.vue";
import ModalForm from "./../modalForm.vue";
import PageStructure from "./../pageStructure.vue";

import axios from "../../axiosConfig"

export default {

    components: {
        Table,
        ModalForm,
        PageStructure
    },
    data() {
        return {
            columns: ["ID", "Nome", "Grupo Muscular"],
            rows: [],
            isExerciseModalOpen: false,
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
                    this.rows = response.data.map((exercise) => {
                        return {
                            id: exercise.id,
                            name: exercise.name,
                            muscleGroup: exercise.muscleGroup,
                            actions: [
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

        handleSubmitExercise(id) {
            if (typeof id === "number") {
                this.editExercise(id);
            } else {
                this.createExercise();
            }
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
            this.isExerciseModalOpen = false;
        },

        showExerciseModal(id) {
            if (typeof id === "number") {
                const exercise = this.rows.find((exercise) => exercise.id === id);
                this.name = exercise.name;
                this.muscleGroup = exercise.muscleGroup;
                this.isExerciseModalOpen = id;
            } else {
                this.name = "";
                this.muscleGroup = "";
                this.isExerciseModalOpen = true;
            }

        },

        showDeleteExerciseModal(id) {
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
                    this.deleteExercise(id);
                }
            })
        },

    }
}
</script>