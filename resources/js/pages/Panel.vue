<template >
    <div class="container" v-if="token">
        <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
            <div class="col-md-3 text-start">
                <button type="button" class="btn btn-outline-primary me-2" @click="logout"> logout</button>
            </div>
        </header>
    </div>

    <div class="m-3">

        <div style="display: flex;justify-content: space-between">
            <div>
                <span>{{this.email}}</span>
            </div>
            <CreateTaskModal></CreateTaskModal>
        </div>

        <AssignedTaskTable  :tasks="this.tasks" ></AssignedTaskTable>
        <created-task-table :createdTasks="this.createdTask"></created-task-table>


    </div>
</template>

<script>
import AssignedTaskTable from "../components/AssignedTaskTable.vue";
import CreateTaskModal from "../components/CreateTaskModal.vue";
import CreatedTaskTable from "../components/CreatedTaskTable.vue";
export default {
    name: "Panel",
    components:{
        AssignedTaskTable,
        CreateTaskModal,
        CreatedTaskTable

    },
    data(){
        return {
            tasks:[],
            createdTask:[],
            email:'',

        }
    },
    computed:{
        token(){
                let token = localStorage.getItem('token');
                if (token){
                    return token;
                }
           }
        },
    mounted() {
        let token = localStorage.getItem('token');
        const headers = {
            "Authorization": `Bearer ${token}`,
        };

        axios.get("/api/panel", { headers })
            .then((data)=>{
                this.email = data.data.email;
                this.tasks = data.data.tasks
                this.createdTask = data.data.created_task;
                console.log(data,'kkkkkkkkkkkkkkk')
            }).catch((error)=>{
                console.log(error);
        });
    },
    methods:{
        logout(){

            let token = localStorage.getItem('token');
            const headers = {
                "Authorization": `Bearer ${token}`,
            };
            axios.get("/api/logout", { headers })
                .then((data)=>{
                    console.log(data);
                    localStorage.removeItem('token');
                    this.$router.push({name:"Login"});
                }).catch((error)=>{
                console.log(error);
            });


        }
    }
}
</script>

<style>

</style>
