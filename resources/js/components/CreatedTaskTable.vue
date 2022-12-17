<template>
    <div class="m-2 p-2" style="border: 1px solid black;text-align: center">
        <h3>Task created by you</h3>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">CreatedTask</th>
                <th scope="col">title</th>
                <th scope="col">dead_line</th>
                <th scope="col">status</th>
                <th scope="col">confirmed_by</th>
                <th scope="col">now_assigned_to</th>
                <th scope="col">assign</th>

            </tr>
            </thead>
            <tbody v-if="createTask" v-for="task in userTasks">
            <tr :class="task.status == 'confirm' ? 'table-success' : '' ">
                <th scope="row">{{task.id}}</th>
                <td>{{task.title}}</td>
                <td>{{task.deadline}}</td>
                <td>{{task.status}}</td>
                <td >
                    <span v-if="task.confirmed_by">{{task.confirmer.email}}</span>
                </td>
                <td>
                    <span v-if="task.last_assigned_user">{{task.last_assigned_user.email}}</span>
                </td>
                <td>
                    <div v-if="!task.confirmed_by && task.status == 'pending'" class="btn-group" role="group" aria-label="Basic example">
                        <AssignTaskModal :taskId="task.id"></AssignTaskModal>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>

</template>

<script>

import AssignTaskModal from "./AssignTaskModal.vue";
export default {
    name: "CreatedTaskTable",
    props:["createdTasks"],
    components:{
        AssignTaskModal
    },
    computed:{
        createTask(){
            console.log(this.createdTasks,'sdf')
            this.userTasks = this.createdTasks;
            return this.createdTasks;
        }
    },
    data(){
        return {
            userTasks:null
        }
    }


}

</script>

<style scoped>

</style>
