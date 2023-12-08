<template>
    <Table title="Lista de Fichas de Treinamento" :columns="columns" :rows="rows" @showCreateModal="showCreateModal"
        @showEditModal="showEditModal" @showDeleteModal="showDeleteModal"></Table>
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
            columns: ["ID", "Exercício", "Séries e Repetições"],
            rows: [],
            isCreateModalOpen: false,
            isEditModalOpen: false,
            currentEditId: 0,
        }
    },
    mounted() {
        console.log("Component mounted.")
        this.fetchTrainingSheets();
    },
    methods: {
        fetchTrainingSheets() {
            axios
                .get("/api/trainingSheets")
                .then((response) => {
                    this.rows = response.data.map((trainingSheet) => {
                        return {
                            id: trainingSheet.id,
                            exercise: trainingSheet.exercise,
                            series: trainingSheet.series,
                            repetitions: trainingSheet.repetitions,
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
        createTrainingSheet() {
            axios
                .post("/api/trainingSheets", {
                    name: this.name,
                    email: this.email,
                    age: this.age,
                    weight: this.weight,
                    height: this.height,
                })
                .then((response) => {
                    this.fetchTrainingSheets();
                    this.isCreateModalOpen = false;
                })
                .catch(console.error);
        },
        editTrainingSheet() {
            axios
                .put(`/api/trainingSheets/${this.currentEditId}`, {
                    name: this.name,
                    email: this.email,
                    age: this.age,
                    weight: this.weight,
                    height: this.height,
                })
                .then((response) => {
                    this.fetchTrainingSheets();
                    this.isEditModalOpen = false;
                })
                .catch(console.error);
        },
        deleteTrainingSheet(id) {
            axios
                .delete(`/api/trainingSheets/${id}`)
                .then((response) => {
                    this.fetchTrainingSheets();
                })
                .catch(console.error);
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
                    this.deleteTrainingSheet(id);
                    this.$swal(
                        'Deletado!',
                        'A ficha foi deletada.',
                        'success'
                    )
                }
            }
            )

        },
    }
}
</script>