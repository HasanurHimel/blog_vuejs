<template>
    <div class="container">
        <div class="row justify-content-center">


            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tag Management</h3>

                        <div class="card-tools">

                            <div><a href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>Tag</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="tag in tags.data">
                                <td>{{ $i++ }}</td>
                                <td>{{ tag.tag }}</td>
                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(tag)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deleteUser(tag.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>

                    <div class="card-footer">
                        <pagination :data="tags" @pagination-change-page="getResults"></pagination>

                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="col-md-7 col-md-offset-4">
            <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" v-show="editMode">Update Tag</h5>
                            <h5 class="modal-title" v-show="!editMode">Create Tag</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">

                            <form @submit.prevent="editMode ? updateTag() : createTag() ">

                                <div class="modal-body">
                                    <div class="form-group">
                                        <input v-model="form.tag" type="text" name="tag"
                                               placeholder="Tag"
                                               class="form-control" :class="{ 'is-invalid': form.errors.has('tag') }">
                                        <has-error :form="form" field="tag"></has-error>
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
                tags :{},
                form: new Form({
                    id:'',
                    tag : '',

                })
            }
        },
        methods: {

            getResults(page = 1) {
                axios.get('api/tag?page=' + page)
                    .then(response => {
                        this.tags = response.data;
                    });
            },


            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#tagModal').modal('show');
            },
            editModal(tags){

                this.editMode= true;
                $('#tagModal').modal('show');
                this.form.fill(tags);
            },

            updateTag() {
                this.form.put('api/tag/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('tagsOperation');
                    $('#tagModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'Tag has been Updated.',
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
                        this.form.delete('api/tag/'+id).then(()=> {
                            Fire.$emit('tagsOperation');
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
            loadtags(){
                this.$Progress.start();
                axios.get('api/tag')
                    .then(({ data }) => { this.tags=data })
                this.$Progress.finish();


            },
            createTag(){
                this.$Progress.start();
                this.form.post('api/tag').then(()=> {
                    Fire.$emit('tagsOperation');
                    $('#tagModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'Tag Created Successfully done'
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
                    this.tags=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadtags();
            Fire.$on('tagsOperation', () => {
                this.$Progress.start();
                this.loadtags();
                this.$Progress.finish();
            });
        }
    }
</script>
