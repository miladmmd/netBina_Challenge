<template>

    <div>
<!--         Button trigger modal-->
        <button type="button" class="btn btn-warning" data-bs-toggle="modal" :data-bs-target="taskModal">AssignTaskTo</button>

        <!-- Modal -->
        <div class="modal fade" :id="taskModalId" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Task{{addTaskId}}</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" ref="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="assign">

                            <select class="form-select" aria-label="Default select example" v-model="fields.user_id" >
                                <option v-for="user in users" :value="user.id">{{user.email}}</option>
                            </select>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" v-if="fields.user_id">assign</button>
                        </form>

                    </div>
                    <div class="modal-footer">
                        <div v-if="message">
                            <div class="alert alert-primary" role="alert">
                                {{message}}
                            </div>
                        </div>
                        <div class="alert alert-danger" role="alert" v-if="error">{{error}}</div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</template>

<script>

export default {
    name: "AssignTaskModal",
    props:["taskId"],
    data(){
        return {
            users:{},
            fields:{},
            message:null,
            error:null
        }
    },
    mounted() {
        let token = localStorage.getItem('token');
        const headers = {
            "Authorization": `Bearer ${token}`,
        };
        axios.get("/api/user/all", { headers })
            .then((data)=>{
                this.users = data.data;
            }).catch((error)=>{

            console.log(error);
        });
    },
    computed:{
        taskModal(){
            return '#'+'Modal'+this.taskId;
        },
        taskModalId(){
            return 'Modal'+this.taskId;
        },
        addTaskId(){
            return this.taskId;
        }
    },
    methods:{

        assign(){
            this.fields.task_id=this.taskId;
            let token = localStorage.getItem('token');
            const headers = {
                "Authorization": `Bearer ${token}`,
            };

            axios.post("/api/task/assign", this.fields,{ headers })
                .then((data)=>{
                    this.$forceUpdate();
                    this.message = `${data.data.title} task assigned successful`
                    var that = this;
                    setTimeout(() => that.$refs.Close.click(), 1000);
                    setTimeout(() => that.message = '', 1000);
                    setTimeout(() => that.$router.go(), 1000);

                }).catch((error)=>{
                        console.log(error.response.status);
                    if(error.response.status == 422) {
                        console.log(error.response.data.data.task_id[0])
                        this.error = error.response.data.data.task_id[0];
                    }else{
                        this.error = error.response.data.error;
                    }

                console.log();
            });
        }
    }
}
</script>

<style scoped>

</style>
