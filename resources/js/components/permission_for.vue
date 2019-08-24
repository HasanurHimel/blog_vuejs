<template>
    <div class="container">
        <div class="row justify-content-center">


            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Management</h3>

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
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="permission_for in permissions_for.data">
                                <td>{{ $i++ }}</td>
                                <td>{{ permission_for.name }}</td>
                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(permission_for)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deleteUser(permission_for.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>

                    <div class="card-footer">
                        <pagination :data="permissions_for" @pagination-change-page="getResults"></pagination>

                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="col-md-7 col-md-offset-4">
            <div class="modal fade" id="permissionForModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="editMode">Update Permission for</h5>
                            <h5 class="modal-title" v-show="!editMode">Create Permission for</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form @submit.prevent="editMode ? updatePermissionFor() : createPermissionFor() ">
                               
                                <div class="modal-body">
                                    <div class="form-group">
                                        <input v-model="form.name" type="text" name="name"
                                               placeholder="Name"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                                        <has-error :form="form" field="name"></has-error>
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
                permissions_for :{},
                form: new Form({
                    id:'',
                    name : '',

                })
            }
        },
        methods: {

            getResults(page = 1) {
                axios.get('api/permission_for?page=' + page)
                    .then(response => {
                        this.permissions_for = response.data;
                    });
            },


            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#permissionForModal').modal('show');
            },
            editModal(permissionFor){

                this.editMode= true;
                $('#permissionForModal').modal('show');
                this.form.fill(permissionFor);
            },

            updatePermissionFor() {
                this.form.put('api/permission_for/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('userOperation');
                    $('#permissionForModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'User has been Updated.',
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
                        this.form.delete('api/permission_for/'+id).then(()=> {
                            Fire.$emit('userOperation');
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
            loadpermissions_for(){
                this.$Progress.start();
                axios.get('api/permission_for')
                    .then(({ data }) => { this.permissions_for=data })
                this.$Progress.finish();


            },
            createPermissionFor(){
                this.$Progress.start();
                this.form.post('api/permission_for').then(()=> {
                    Fire.$emit('userOperation');
                    $('#permissionForModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'Permission For Created Successfully done'
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
            Fire.$on('searching', () => {
                let query=this.$parent.search;
                axios.get('api/searching?q='+query).then(({ data }) => {
                    this.permissions_for=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadpermissions_for();
            Fire.$on('userOperation', () => {
                this.$Progress.start();
                this.loadpermissions_for();
                this.$Progress.finish();
            });
        }
    }
</script>
