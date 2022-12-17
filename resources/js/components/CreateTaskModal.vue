<template>
    <div>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            create task
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submit">
                            <div class="mb-3">
                                <label for="titleTask" class="form-label">Title</label>
                                <input type="text" class="form-control" id="titleTask" placeholder="title" v-model="fields.title">
                                <div style="color:red" v-if="this.errors.title">{{this.errors.title[0]}}</div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">select deadline</label>
                                <datepicker v-model="picked" />
                                <div style="color:red" v-if="this.errors.deadline">{{this.errors.deadline[0]}}</div>
                            </div>

                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">create</button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>

import Datepicker from 'vue3-datepicker';
export default {
    name: "CreateTaskModel",
    components: {
        Datepicker
    },
    data(){
        return {
            fields:{},
            picked: new Date(),
            errors:[]
        }
    },

    methods:{
        submit(){
            let objectDate = this.picked;
            let month = objectDate.getMonth() + 1;
            let year = objectDate.getFullYear();
            let day = objectDate.getDate();
            if (day < 10) {
                day = '0' + day;
            }
            if (month < 10) {
                month = `0${month}`;
            }
            let fulldate = year + "-" + month + "-" + day;
            this.fields.deadline = fulldate;

            let token = localStorage.getItem('token');
            const headers = {
                "Authorization": `Bearer ${token}`,
            };

            axios.post('/api/task',this.fields,{ headers }).then((data)=>{
                this.$router.go();
            }).catch((error)=>{
                console.log(error)
                this.errors = error.response.data.data;
            })
        }
    }
}
</script>

<style scoped>

</style>
