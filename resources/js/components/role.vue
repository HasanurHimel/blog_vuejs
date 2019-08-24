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
                        <h3 class="card-title">Role Management</h3>

                        <div class="card-tools">

                            <div><a href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>Name</th>
                                <th>role</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="role in roles">
                                <td>{{ $i++ }}</td>
                                <td>{{ role.name }}</td>
                                <td >
                                    <span v-for="permission in role.permissions">
                                    {{ permission.name }},
                                    </span>

                                </td>
                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(role)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deleteRole(role.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="roles" @pagination-change-page="getResults"></pagination>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="container">
            <div class="col-md-9 col-md-offset-3">
                <div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="editMode">Update Role Data</h5>
                                <h5 class="modal-title" v-show="!editMode">Create Role data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form @submit.prevent="editMode ? updaterole() : createrole() ">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.name" type="text" name="name"
                                                   placeholder="Name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                            <has-error :form="form" field="name"></has-error>
                                        </div>



                                        <div class="row">
                                            <div class="col-md-12">



                                                <div class="row">
                                                    <div v-for="permission_for in permissions_for" v-if="permission_for.permissions!==null" class="col-md-6">



                                                        <div class="col-sm-6 col-xs-6" style="min-height: 80px">
                                                            <div class="form-group">
                                                                <label>{{ permission_for.name }}</label>
                                                                <div class="checkbox" v-for="permission in permission_for.permissions" :key="permission.id">
                                                                   <label>
                                                                       <input type="checkbox" id="permissions" v-model="form.permissions" @change="check(permission.id)" v-bind:value="permission.id" class="flat-red">{{ permission.id }} ,{{ permission.name }}
                                                                   </label>
                                                                </div>
                                                            </div>
                                                        </div>


                                                    </div>
                                                </div>


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
                roles :{},
                permissions_for:{},
                form: new Form({
                    id:'',
                    name : '',
                    permissions: [],
                })
            }
        },
        methods: {


            getResults(page = 1) {
                axios.get('api/role?page=' + page)
                    .then(response => {
                        this.roles = response.data;
                    });
            },


            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#roleModal').modal('show');
            },
            editModal(role){

                this.editMode= true;
                $('#roleModal').modal('show');
                this.form.fill(role);
            },

            updaterole() {
                this.form.put('api/role/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('roleOperation');
                    $('#roleModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Role has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });



            },


            deleteRole(id){
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
                        this.form.delete('api/role/'+id).then(()=> {
                            Fire.$emit('roleOperation');
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
            loadroles(){
                axios.get('api/role').then(({ data }) => { this.roles= data.roles })
            },
            loadPermissionFor(){
                axios.get('api/role')
                    .then(({ data }) => { this.permissions_for= data.permissions_for })
            },

            createrole(){
                this.$Progress.start();
                this.form.post('api/role').then(()=> {
                    Fire.$emit('roleOperation');
                    $('#roleModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'role Created Successfully done'
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

            this.loadPermissionFor();
            Fire.$on('searching', () => {
                let query=this.$parent.search;
                axios.get('api/searching?q='+query).then(({ data }) => {
                    this.roles=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadroles();
            Fire.$on('roleOperation', () => {
                this.$Progress.start();
                this.loadroles();
                this.$Progress.finish();
            });
        }
    }
</script>
