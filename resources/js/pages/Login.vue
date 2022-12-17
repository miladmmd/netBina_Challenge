<template>
    <div class="modal modal-signin position-static d-block bg-secondary py-5" tabindex="-1" role="dialog" id="modalSignin">
        <div class="modal-dialog" role="document">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header p-5 pb-4 border-bottom-0">
                    <h1 class="fw-bold mb-0 fs-2">Please Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-5 pt-0">
                    <form @submit.prevent="submit" class="">
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control rounded-3" id="floatingInput" placeholder="name@example.com" v-model="fields.email">
                            <label for="floatingInput">Email address</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control rounded-3" id="floatingPassword" placeholder="Password" v-model="fields.password">
                            <label for="floatingPassword">Password</label>
                        </div>
                        <div class="form-floating mb-3" v-if="errors">
                            <ul>
                                <li v-for="error in errors">
                                    <span style="color: red" >{{ error }}</span>
                                </li>
                            </ul>

                        </div>


                        <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit">Sign up</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Login",
    data(){
        return {
            fields:{

            },
            errors:{

            }
        }
    },
    methods:{
        submit(){
            // let storage = localStorage.getItem('token');

            axios.post('/api/login',this.fields).then((data)=>{
                localStorage.setItem('token',data.data.token);

                this.$router.push({name:"Panel"});
            }).catch((error)=>{
                this.errors = error.response.data.errors;
                console.log(error.response.data.errors);
            })
        }
    }
}
</script>

<style scoped>

</style>
