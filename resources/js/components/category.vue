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
                        <h3 class="card-title">category Management</h3>

                        <div class="card-tools">

                            <div><a href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>Category name</th>
                                <th>Category description</th>
                                <th>Sattus</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="category in categories.data">
                                <td>{{ $i++ }}</td>
                                <td>{{ category.category_name }}</td>
                                <td>{{ category.category_description }}</td>
                                <td v-if="category.publication_status===1">Published</td>
                                <td v-if="category.publication_status===0">UnPublished</td>

                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(category)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deletecategory(category.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
                                        <div class="card-footer">
                                            <pagination :data="categories" @pagination-change-page="getResults"></pagination>
                                        </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="container">
            <div class="col-md-9 col-md-offset-3">
                <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="editMode">Update category Data</h5>
                                <h5 class="modal-title" v-show="!editMode">Create category data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form @submit.prevent="editMode ? updatecategory() : createcategory() ">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.category_name" type="text" name="category_name"
                                                   placeholder="Category name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('category_name') }">
                                            <has-error :form="form" field="category_name"></has-error>
                                        </div>


                                        <div class="form-group">
                                      <textarea v-model="form.category_description" name="category_description" id="category_description"
                                                placeholder="Category description"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('category_description') }"></textarea>
                                            <has-error :form="form" field="category_description"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="radio">
                                                <label><input type="radio" v-model="form.publication_status" name="publication_status" value="1" class="flat-red" :class="{ 'is-invalid': form.errors.has('publication_status') }">Published</label>
                                                <label><input type="radio" v-model="form.publication_status" name="publication_status" value="0" class="flat-red" :class="{ 'is-invalid': form.errors.has('publication_status') }">UnPublished</label>
                                                <has-error :form="form" field="publication_status"></has-error>
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
                categories :{},
                form: new Form({
                    id:'',
                    category_name:'',
                    category_description:'',
                    publication_status:''
                })
            }
        },
        methods: {


            getResults(page = 1) {
                axios.get('api/category?page=' + page)
                    .then(response => {
                        this.permissions = response.data;
                    });
            },

            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#categoryModal').modal('show');
            },
            editModal(category){
                this.editMode= true;
                $('#categoryModal').modal('show');
                this.form.fill(category);
            },

            updatecategory() {
                this.$Progress.start();
                this.form.put('api/category/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('categoryOperation');
                    $('#categoryModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'category has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });
            },


            deletecategory(id){
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
                        this.form.delete('api/category/'+id).then(()=> {
                            Fire.$emit('categoryOperation');
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
            loadcategories(){
                axios.get('api/category').then(({ data }) => { this.categories=data })
            },



            createcategory(){
                this.$Progress.start();

                this.form.post('api/category').then(()=> {
                    Fire.$emit('categoryOperation');
                    $('#categoryModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'category Created Successfully done'
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
                    this.categories=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadcategories();
            Fire.$on('categoryOperation', () => {
                this.$Progress.start();
                this.loadcategories();
                this.$Progress.finish();
            });
            this.$Progress.finish();
        }
    }
</script>
