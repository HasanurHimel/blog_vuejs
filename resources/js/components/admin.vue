<style>

    .col-sm-6 {
        flex: 0 0 50%;
        max-width: 100%;
    }
</style>




<template>
    <div class="container">
        <div class="row justify-content-center">


            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Admin Management</h3>

                        <div class="card-tools">

                            <div><a href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="admin in admins.data">
                                <td>{{ $i++ }}</td>
                                <td>{{ admin.name }}</td>
                                <td>{{ admin.email }}</td>
                                <td v-for="role in admin.roles">{{ role.name }}</td>
                                <td v-if="admin.status===1">Active</td>
                                <td v-if="admin.status===0">InActive</td>

                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(admin)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deleteadmin(admin.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="admins" @pagination-change-page="getResults"></pagination>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="container">
            <div class="col-md-9 col-md-offset-3">
                <div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="editMode">Update admin Data</h5>
                                <h5 class="modal-title" v-show="!editMode">Create admin data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form @submit.prevent="editMode ? updateadmin() : createadmin() ">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.name" type="text" name="name"
                                                   placeholder="Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <input v-model="form.email" type="email" name="email"
                                                   placeholder="Email Address"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                                            <has-error :form="form" field="email"></has-error>
                                        </div>

                                        <div class="form-group" v-if="editMode===false">
                                            <input v-model="form.password" type="password" name="password" id="password"
                                                   placeholder="Password"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('password') }" autocomplete="new-password">
                                            <has-error :form="form" field="password"></has-error>
                                        </div>

                                        <div class="form-group" v-if="editMode===false">
                                            <input type="password" name="password_confirmation" id="password_confirmation"
                                                   placeholder="Re-enter Password" class="form-control"
                                                   v-model="form.password_confirmation"
                                                   data-vv-as="Re-enter Password" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                            <has-error :form="form" field="password_confirmation"></has-error>
                                        </div>

                                        <div class="form-group">
                                      <textarea v-model="form.bio" name="bio" id="bio"
                                            placeholder="Short bio for user"
                                            class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                                            <has-error :form="form" field="bio"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <input v-model="form.mobile" type="number" name="mobile"
                                                   placeholder="mobile"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('mobile') }">
                                            <has-error :form="form" field="mobile"></has-error>
                                        </div>


                                        <div class="form-group">
                                            <select name="role" v-model="form.role" id="role" class="form-control" :class="{ 'is-invalid': form.errors.has('role') }">
                                                <option value="">Select Role</option>

                                                <option v-for="role in rolesData" :value="role.id" >{{ role.name }}</option>

                                            </select>
                                            <has-error :form="form" field="role"></has-error>
                                        </div>


                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="radio">
                                                <label><input type="radio" v-model="form.status" name="status" value="1" class="flat-red" :class="{ 'is-invalid': form.errors.has('status') }">Active</label>
                                                <label><input type="radio" v-model="form.status" name="status" value="0" class="flat-red" :class="{ 'is-invalid': form.errors.has('status') }">InActive</label>
                                                <has-error :form="form" field="status"></has-error>
                                            </div>

                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                        <button type="submit" v-show="editMode" class="btn btn-success">Update</button>
                                        <button type="submit" v-show="!editMode" class="btn btn-primary">Create</button>
                                    </div>

                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>
</template>

<script>
    import Form from 'vform'
    export default {

        data() {
            return {

                editMode: false,
                rolesData :[],
                admins :{},
                form: new Form({
                    id:'',
                    name : '',
                    email: '',
                    password: '',
                    password_confirmation:'',
                    mobile: '',
                    bio: '',
                    role: '',
                    roles:'',
                    status: ''
                })
            }
        },
        methods: {


            getResults(page = 1) {
                axios.get('api/admin?page=' + page)
                    .then(response => {
                        this.permissions = response.data;
                    });
            },

            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#adminModal').modal('show');
            },
            editModal(admin){
                this.editMode= true;
                $('#adminModal').modal('show');
                this.form.fill(admin);
            },

            updateadmin() {
                this.$Progress.start();
                this.form.put('api/admin/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('adminOperation');
                    $('#adminModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'admin has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });
            },


            deleteadmin(id){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        this.form.delete('api/admin/'+id).then(()=> {
                            Fire.$emit('adminOperation');
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }).catch(()=>{
                            Swal.fire({
                                type: 'error',
                                title: 'Oops...',
                                text: 'Something went wrong!',
                                // footer: '<a href>Why do I have this issue?</a>'
                            })
                        });
                    }
                })
            },
            loadadmins(){
                axios.get('api/admin').then(({ data }) => { this.admins= data.admins })
            },


            loadroles(){
                    axios.get('api/admin').then(({ data }) => { console.log(data.roles) })
                        // .then(({ data }) => { this.roles= data.roles })
            },

            createadmin(){
                this.$Progress.start();
                this.form.post('register').then(()=> {
                    Fire.$emit('adminOperation');
                    $('#adminModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'admin Created Successfully done'
                    });


                }).catch(()=> {
                    Toast.fire({
                        type: 'error',
                        title: 'Some error'
                    });

                });

                this.$Progress.finish();

            }
        },


        created() {
            axios.get('api/admin')
                .then(({ data }) => { this.rolesData= data.roles });

            Fire.$on('searching', () => {
                let query=this.$parent.search;
                axios.get('api/searching?q='+query).then(({ data }) => {
                    this.admins=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadadmins();
            Fire.$on('adminOperation', () => {
                this.$Progress.start();
                this.loadadmins();
                this.$Progress.finish();
            });
        }
    }
</script>
