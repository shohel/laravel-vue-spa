<template>
    <div>


        <div class="container  mt-5">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">Register</div>

                        <div class="card-body">
                            <form @submit="submit" method="POST" action="#">


                                <div class="alert alert-warning" v-html="api_response.msg" v-if="!api_response.success"></div>

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control" v-model="user.name" name="name" value="">

                                        <span class="invalid-feedback" style="display: block;" v-if="errors.name">
                                            <strong>{{errors.name}}</strong>
                                        </span>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="user_name" class="col-md-4 col-form-label text-md-right">User Name</label>

                                    <div class="col-md-6">

                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">@</div>
                                            </div>
                                            <input id="user_name" type="text" class="form-control" v-model="user.user_name" name="user_name">

                                            <div class="input-group-append" v-html="tmpl.indicator"></div>
                                        </div>


                                        <span class="invalid-feedback" style="display: block;" v-if="errors.user_name">
                                            <strong>{{errors.user_name}}</strong>
                                        </span>

                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" v-model="user.email" class="form-control">

                                        <span class="invalid-feedback" style="display: block;" v-if="errors.email">
                                            <strong>{{errors.email}}</strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password" v-model="user.password" class="form-control" name="password">

                                        <span class="invalid-feedback" style="display: block;" v-if="errors.password">
                                            <strong>{{errors.password}}</strong>
                                        </span>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" v-model="user.password_confirmation" class="form-control" name="password_confirmation">

                                        <span class="invalid-feedback" style="display: block;" v-if="errors.password_confirmation">
                                            <strong>{{errors.password_confirmation}}</strong>
                                        </span>
                                    </div>



                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Register
                                        </button>
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
        data: function(){
            return {
                errors : {},
                user: { name: '', user_name: '', email: '', password : '', password_confirmation: '' },
                tmpl: {indicator : ''},
                api_response : {success: true, msg: ''}
            }
        },

        watch: {
            'user.name' : function(val){
                let slug = _.kebabCase(val);
                this.user.user_name = slug;

                return slug;
            },
            'user.user_name' : function(user_name){
                delete this.errors.user_name;
                let app = this;
                this.user.user_name = _.kebabCase(user_name);

                if (user_name.length < 3){
                    app.tmpl.indicator = ` <div class="input-group-text text-danger"><i class="fas fa-exclamation-triangle"></i> </div>`;
                    this.errors.user_name = "User Name should be min 3 characters";
                    return;
                }

                axios.post(laravel.route.user_name_availability, {user_name : user_name})
                    .then(function(res){
                        if (res.data.success){
                            app.tmpl.indicator = `
                            <div class="input-group-text text-success"><i class="fas fa-check-circle"></i> </div>
                        `
                        }else {
                            app.api_response.success = false;
                            app.api_response.msg = res.data.msg;

                            app.errors.user_name = "This Username has been taken already";

                            app.tmpl.indicator = app.tmpl.indicator = ` <div class="input-group-text text-danger"><i class="fas fa-exclamation-triangle"></i> </div>`;

                        }

                    })
                    .catch(function (res) {

                    })

                //Check Ajax User Name
            }
        },
        methods : {
            submit(e){
                e.preventDefault();
                this.errors = {};

                if ( ! this.user.name){
                    this.errors.name = "The Name field is required";
                }
                if ( ! this.user.user_name){
                    this.errors.user_name = "The User Name field is required";
                }
                if ( ! this.user.email){
                    this.errors.email = "The E-Mail Address field is required";
                }
                if ( ! this.user.password){
                    this.errors.password = "The Password field is required";
                }

                if (this.user.password.length < 6){
                    this.errors.password = "The Password must be at least 6 characters.";
                }

                if ( ! this.user.password_confirmation){
                    this.errors.password_confirmation = "The Password Confirmation field is required";
                }

                if (this.user.password !== this.user.password_confirmation){
                    this.errors.password_confirmation = "Your password does not matched with confirm password";
                }

                if ( ! _.size(this.errors)){
                    //call api to register this user
                    let input = this.user;
                    let app = this;

                    axios.post(laravel.route.api_user_register, input)
                        .then(function(res){
                            if (res.data.success){
                                location.href = '/';
                            }else {
                                app.api_response.success = false;
                                app.api_response.msg = res.data.msg;
                            }
                        })
                        .catch(function(res){

                        })
                }
            },

        }
    }
</script>