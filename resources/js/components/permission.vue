<template>
    <div class="container">
        <div class="row justify-content-center">


            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Role Permission Management</h3>

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
                                <th>Permission For</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="permission in permissions.data">
                                <td>{{ $i++ }}</td>
                                <td>{{ permission.name }}</td>
                                <td>{{ permission.permission_for.name }}</td>
                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(permission)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deleteUser(permission.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="permissions" @pagination-change-page="getResults"></pagination>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="col-md-7 col-md-offset-4">
            <div class="modal fade" id="permissionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="editMode">Update Permission Data</h5>
                            <h5 class="modal-title" v-show="!editMode">Create Permission Name</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form @submit.prevent="editMode ? updatePermission() : createPermission() ">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input v-model="form.name" type="text" name="name"
                                               placeholder="Name"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
                                    </div>



                                    <div class="form-group">
                                        <select name="permissions_for" v-model="form.permission_for_id" id="permission_for_id" class="form-control" :class="{ 'is-invalid': form.errors.has('permission_for_id') }">
                                            <option value="">Select Permission for name</option>

                                            <option v-for="permission_for in permissions_for" :value="permission_for.id" >{{ permission_for.name }}</option>

                                        </select>
                                        <has-error :form="form" field="permission_for_id"></has-error>
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
</template>

<script>
    import Form from 'vform'
    export default {

        data() {
            return {
                editMode: false,
                permissions :{},
                permissions_for:{},
                form: new Form({
                    id:'',
                    name : '',
                    permission_for_id: '',

                })
            }
        },
        methods: {

            getResults(page = 1) {
                axios.get('api/permission?page=' + page)
                    .then(response => {
                        this.permissions = response.data;
                    });
            },


            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#permissionModal').modal('show');
            },
            editModal(user){

                this.editMode= true;
                $('#permissionModal').modal('show');
                this.form.fill(user);
            },

            updatePermission() {
                this.form.put('api/permission/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('permissionOperation');
                    $('#permissionModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Permission has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });



            },


            deleteUser(id){
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
                        this.form.delete('api/permission/'+id).then(()=> {
                            Fire.$emit('permissionOperation');
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
            loadpermissions(){
                this.$Progress.start();
                axios.get('api/permission').then(({ data }) => { this.permissions= data.permissions })
                this.$Progress.finish();
            },
            loadPermissionsFor(){
                this.$Progress.start();
                axios.get('api/permission')
                    .then(({ data }) => { this.permissions_for= data.permissions_for })
                this.$Progress.finish();
            },

            createPermission(){
                this.$Progress.start();
                this.form.post('api/permission').then(()=> {
                    Fire.$emit('permissionOperation');
                    $('#permissionModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'Permission Created Successfully done'
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

            this.loadPermissionsFor();
            Fire.$on('searching', () => {
                let query=this.$parent.search;
                axios.get('api/searching?q='+query).then(({ data }) => {
                    this.permissions=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadpermissions();
            Fire.$on('permissionOperation', () => {
                this.$Progress.start();
                this.loadpermissions();
                this.$Progress.finish();
            });
        }
    }
</script>
