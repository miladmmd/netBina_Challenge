<template>
    <div class="m-2 p-2" style="border: 1px solid black;text-align: center">
        <h3>Task assigned to you</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">AssignedTask</th>
                <th scope="col">title</th>
                <th scope="col">assigned_to_you_by</th>
                <th scope="col">now_assigned_to</th>
                <th scope="col">confirmed_by</th>
                <th scope="col">dead_line</th>
                <th scope="col">status</th>
                <th scope="col">confirm/assign</th>


            </tr>
            </thead>
            <tbody v-if="assignTasks" v-for="task in userTasks">
                <tr :class="task.status == 'confirm' ? 'table-success' : '' ">
                    <th scope="row">{{task.id}}</th>
                    <td>{{task.title}}</td>
                    <td>
                      <div v-if="task.allocator_email">{{task.allocator_email}}</div>
                    </td>
                    <td>
                        <span v-if="task.last_assigned_user">{{task.last_assigned_user.email}}</span>
                    </td>
                    <td>
                        <span v-if="task.confirmer">{{task.confirmer.email}}</span>
                    </td>
                    <td>{{task.deadline}}</td>
                    <td>{{task.status}}</td>
                    <td v-if="!task.confirmed_by && task.status == 'pending'">
                        <div class="btn-group" role="group" aria-label="Basic example">

                            <input type="hidden" name="task_id"  >
                            <button type="button" class="btn btn-primary" @click="cofirmed(task.id)" >Confirmed</button>

                            <AssignTaskModal :taskId="task.id"></AssignTaskModal>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="error">
            <span style="color:red" v-for="error in errors">{{error}}</span>
        </div>

    </div>

</template>

<script>

import AssignTaskModal from "./AssignTaskModal.vue";
export default {
    name: "AssignedTaskTable",
    props:['tasks'],
    components:{
        AssignTaskModal
    },
    computed:{
        assignTasks(){
            this.userTasks = this.tasks;
            return this.tasks;
        }
    },
    data(){
        return {
            userTasks: null,
            fields:{},
            errors:[]
        }
    },
    methods:{
        cofirmed(id){

            this.fields.task_id = id;

            let token = localStorage.getItem('token');

            const headers = {
                "Authorization": `Bearer ${token}`,
            };

            axios.post(`/api/task/confirm/`,this.fields, { headers })
                .then((data)=>{
                    console.log(data)
                    this.$router.go();
                }).catch((error)=>{
                  console.log(error)
              if(error.response.status == 422) {
                this.errors = error.response.data.data.task_id[0];
              }else{
                this.errors = error.response.data.error;
              }
            });

        }
    }

}
</script>

<style scoped>

</style>
