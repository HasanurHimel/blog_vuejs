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
                        <h3 class="card-title">Seo Management</h3>

                        <div class="card-tools">

                            <div><a v-if="seos.length==0" href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>Title</th>
                                <th>seo</th>
                                <th>meta tags</th>
                                <th>Meta description</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="seo in seos">
                                <td>{{ $i++ }}</td>
                                <td>{{ seo.web_title }}</td>
                                <td>{{ seo.web_admin }}</td>
                                <td>{{ seo.meta_tag }}</td>
                                <td>{{ seo.meta_description }}</td>

                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(seo)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deleteseo(seo.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
<!--                    <div class="card-footer">-->
<!--                        <pagination :data="seos" @pagination-change-page="getResults"></pagination>-->
<!--                    </div>-->

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="container">
            <div class="col-md-9 col-md-offset-3">
                <div class="modal fade" id="seoModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="editMode">Update seo Data</h5>
                                <h5 class="modal-title" v-show="!editMode">Create seo data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form @submit.prevent="editMode ? updateseo() : createseo() ">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.web_title" type="text" name="web_title"
                                                   placeholder="Web title"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('web_title') }">
                                            <has-error :form="form" field="web_title"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <input v-model="form.web_admin" type="text" name="web_admin"
                                                   placeholder="Web admin"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('web_admin') }">
                                            <has-error :form="form" field="web_admin"></has-error>
                                        </div>


                                        <div class="form-group">
                                      <textarea v-model="form.meta_tag" name="meta_tag" id="meta_tag"
                                                placeholder="Meta tags"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('meta_tag') }"></textarea>
                                            <has-error :form="form" field="meta_tag"></has-error>
                                        </div>

                                        <div class="form-group">
                                      <textarea v-model="form.meta_description" name="meta_description" id="meta_description"
                                                placeholder="Meta description"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('meta_description') }"></textarea>
                                            <has-error :form="form" field="meta_description"></has-error>
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

                emptyData: false,
                editMode: false,
                seos :{},
                form: new Form({
                    id:'',
                    web_title:'',
                    web_admion:'',
                    meta_tag:'',
                    meta_description:'',
                })
            }
        },
        methods: {


            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#seoModal').modal('show');
            },
            editModal(seo){
                this.editMode= true;
                $('#seoModal').modal('show');
                this.form.fill(seo);
            },

            updateseo() {
                this.$Progress.start();
                this.form.put('api/seo/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('seoOperation');
                    $('#seoModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'seo has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });
            },


            deleteseo(id){
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
                        this.form.delete('api/seo/'+id).then(()=> {
                            Fire.$emit('seoOperation');
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
            loadseos(){
                axios.get('api/seo').then(({ data }) => { this.seos=data })
            },



            createseo(){
                this.$Progress.start();


                // };
                this.form.post('api/seo').then(()=> {
                    Fire.$emit('seoOperation');
                    $('#seoModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'seo Created Successfully done'
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
            this.$Progress.start();


            Fire.$on('searching', () => {
                let query=this.$parent.search;
                axios.get('api/searching?q='+query).then(({ data }) => {
                    this.seos=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadseos();
            Fire.$on('seoOperation', () => {
                this.$Progress.start();
                this.loadseos();
                this.$Progress.finish();
            });
            this.$Progress.finish();
        }
    }
</script>
