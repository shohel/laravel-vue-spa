<template>
    <div class="vue-login mt-5">

        <page-title :title="title"></page-title>


        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Login</div>

                        <div class="card-body">
                            <form method="POST" action="" @submit="signIn">

                                <div class="alert alert-warning" v-html="api_response.msg" v-if="!api_response.success"></div>

                                <div class="form-group row">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right"> E-Mail Address</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-envelope" v-if="!is_valid_email"></i>
                                                    <i class="fas fa-envelope-open" v-if="is_valid_email"></i>
                                                </div>
                                            </div>
                                            <input id="email" type="email" class="form-control" v-model="credential.email" name="email" value="" required autofocus>
                                        </div>


                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="fas fa-lock" v-if="!credential.password"></i>
                                                    <i class="fas fa-lock-open" v-if="credential.password"></i>
                                                </div>
                                            </div>
                                            <input id="password" type="password" class="form-control" v-model="credential.password" name="password" required>
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" v-model="credential.remember" name="remember"> Remember Me {{credential.remember? '(Yes)' : ''}}
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-sign-in-alt"></i> Login
                                        </button>

                                        <a class="btn btn-link" :href="forgot_password_url">
                                            Forgot Your Password?
                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>


<script>
    export default {
        name: "VueLogin",
        data: function(){
            return {
                title: 'Login',
                credential: {
                    email: '',
                    password: '',
                    remember: false,
                },
                is_valid_email : false,
                api_response : {success: true, msg: ''},
                forgot_password_url : laravel.route.password_request,

            }
        },
        watch : {
            'credential.email' : function(value){
                this.is_valid_email = this.validEmail(value);
            }
        },
        methods: {
            signIn(e){
                e.preventDefault();

                let app = this;

                axios.post(laravel.route.api_sign_in, this.credential)
                    .then( (res) => {
                        if (res.data.success){
                            location.href = '/';
                        }else {
                            app.api_response.success = false;
                            app.api_response.msg = res.data.msg;
                        }
                    })
                    .catch((res) => {

                    })

            },
            validEmail: function(email) {
                let re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }
        }
    }
</script>