<template>
      <Table 
        title="Lista de Estudantes" 
        :columns="columns" 
        @showCreateModal="showStudentModal"
        >
        <tr v-for="row in rows" :key="row.id">
            <td v-for="(value, key) in Object.values(row).slice(0,-2)" :key="value">{{value}}</td>
            <td v-for="action in row.actions" :key="action">
              <span v-if="action.includes('Edit Row')">
                <button class="btn btn-primary" @click="showStudentModal(row.id)">Edit</button>
              </span>
              <span v-else-if="action.includes('Delete Row')">
                <button class="btn btn-danger" @click="showDeleteStudentModal(row.id)">Delete</button>
              </span>
              <span v-else-if="action.includes('Edit Training Sheet')">
                <button class="btn btn-info" @click="showSheetModal(row.training_sheet.id, row.id)">Editar Ficha</button>
              </span>
              <span v-else-if="action.includes('Create Training Sheet')">
                <button class="btn btn-info" @click="showSheetModal(null,row.id)">Criar Ficha</button>
              </span>
            </td>
        </tr>
      </Table>
      <ModalForm :id="isStudentModalOpen" title="Editar Estudante" @submit="editStudent" :isModalOpen="isStudentModalOpen || typeof isStudentModalOpen ==='number'" @closeModal="closeModal">
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
      <ModalForm :id="isSheetModalOpen" title="Editar Ficha de Treinamento" @submit="createTrainingSheet" :isModalOpen="isSheetModalOpen || typeof isSheetModalOpen === 'number'" @closeModal="closeModal">
          <label for="exercise">Exercícios</label>
          <table class="table">
            <thead>
              <tr>
                <th>Nome</th>
                <th>Séries</th>
                <th>Repetições</th>
                <th><button type="button" class="btn btn-primary" @click="showExerciseModal()">
                  <b><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                      class="mr-2 bi bi-plus-circle-fill" viewBox="0 0 16 16">
                      <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                    </svg> Adicionar</b></button>
                  </th>
              </tr>
             
            </thead>
            <tbody>
              <tr v-for="exercise in exercises" :key="exercise.id">
                <td>{{exercise.name}}</td>
                <td>{{exercise.pivot.series}}</td>
                <td>{{exercise.pivot.repetitions}}</td>
                <td> <button class="btn btn-danger" @click="removeExercise(exercise.id)">Excluir</button></td>
              </tr>
            </tbody>
          </table>
      </ModalForm>   
      <ModalForm title="Adicionar Exercício" :isModalOpen="isExerciseModalOpen" @submit="addExercise" @closeModal="closeExerciseModal">
          <label for="exercise">Exercício</label>
          <select class="form-control" id="exercise" v-model="exerciseId">
            <option v-for="exercise in allExercises" :key="exercise.id" :value="exercise.id">{{exercise.name}}</option>
          </select>
          <label for="series">Séries</label>
          <input type="number" class="form-control" id="series" v-model="series" required>
          <label for="repetitions">Repetições</label>
          <input type="number" class="form-control" id="repetitions" v-model="repetitions" required>
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
      isStudentModalOpen: false,
      isSheetModalOpen: false,
      isExerciseModalOpen: false,
    }
  },  
  mounted() {
    console.log("Component mounted.") 
    this.fetchStudents();
  },
  methods: {

    fetchStudents() {
      return axios
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
              training_sheet: student.training_sheet,
              actions: 
              [
                'Edit Row',
                'Delete Row',
                student.training_sheet ? 'Edit Training Sheet' : 'Create Training Sheet',
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
      this.isStudentModalOpen = false;
      this.isSheetModalOpen = false;
    },

    closeExerciseModal() {
      
      this.isExerciseModalOpen = false;
    },

    showSheetModal(trainingSheetId, studentId) {
      if(typeof trainingSheetId === 'number') {
        const student = this.rows.find(student => student.training_sheet?.id === trainingSheetId);  
        this.studentId = student.id;
        this.exercises = student.training_sheet?.exercises ?? [];
        this.isSheetModalOpen = trainingSheetId;
      } else {
        this.studentId = studentId;
        this.exercises = [];
        this.isSheetModalOpen = true;

      }

    },

    showStudentModal(id) {
      if(typeof id === 'number') {
        const student = this.rows.find(student => student.id === id);
        this.name = student.name;
        this.email = student.email;
        this.age = student.age;
        this.weight = student.weight;
        this.height = student.height;
        this.isStudentModalOpen = id;
      } else {
        this.name = "";
        this.email = "";
        this.age = "";
        this.weight = "";
        this.height = "";
        this.isStudentModalOpen = true;
      }  
    
    },

    showExerciseModal() {
      this.fetchExercises().then(() => {
        this.isExerciseModalOpen = true;
      });
    },


    showDeleteStudentModal(id) {
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
    fetchExercises() {
      return axios
        .get("/api/exercises")
        .then((response) => {
          this.allExercises = response.data.map((exercise) => {
            return {
              id: exercise.id,
              name: exercise.name,
              muscleGroup: exercise.muscleGroup,
            };
          });
        })
        .catch(console.error);
    },

    addExercise() {
      const trainingSheetId = this.isSheetModalOpen;
      const studentId = this.studentId;
      axios
        .post(`/api/training_sheets/${this.isSheetModalOpen}/exercises/${this.exerciseId}`, {
          exercise_id: this.exercise,
          series: this.series,
          repetitions: this.repetitions,
          studentId: this.studentId,
        })
        .then((response) => this.fetchStudents())
        .then((response) => this.closeExerciseModal())
        .then((response) => this.closeModal())
        .then(() => {
          this.showSheetModal(trainingSheetId, studentId)
        })
        .catch(console.error);
     
    },

 

    removeExercise(id) {
      const trainingSheetId = this.isSheetModalOpen;
      axios
        .delete(`/api/training_sheets/${this.isSheetModalOpen}/exercises/${id}`) 
        .then((response) => this.fetchStudents()) 
        .then((response) => this.closeModal()) 
        .then(() => {
            this.showSheetModal(trainingSheetId)
        }) 
        .catch(console.error);
    },
    
  }
};
</script>

