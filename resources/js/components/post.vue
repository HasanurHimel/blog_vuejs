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
                        <h3 class="card-title">Posts Management</h3>

                        <div class="card-tools">

                            <div><a href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>Title</th>
                                <th>category</th>
                                <th>Photo</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="post in posts">
                                <td>{{ $i++ }}</td>
                                <td>{{ post.title }}</td>
                                <td>{{ post.category.name }}</td>
                                <td><img v-bind:src="'images/posts/'+post.photo" alt="" height="80px" width="80px"></td>
                                <td v-if="post.status===1">Published</td>
                                <td v-if="post.status===0">UnPublished</td>

                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(post)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deletepost(post.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
<!--                                        <div class="card-footer">-->
<!--                                            <pagination :data="posts" @pagination-change-page="getResults"></pagination>-->
<!--                                        </div>-->

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="container">
            <div class="">
                <div class="modal fade" id="postModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="editMode">Update post Data</h5>
                                <h5 class="modal-title" v-show="!editMode">Create post data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form @submit.prevent="editMode ? updatepost() : createpost() ">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.title" type="text" name="title"
                                                   placeholder="title"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('title') }">
                                            <has-error :form="form" field="title"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <select name="category_id" v-model="form.category_id" id="category_id" class="form-control" :class="{ 'is-invalid': form.errors.has('category_id') }">
                                                <option value="">Select Category</option>

                                                <option v-for="category in categories" :value="category.id" >{{ category.name }}</option>

                                            </select>
                                            <has-error :form="form" field="category_id"></has-error>
                                        </div>


                                        <div class="form-group">
                                            <label>Tags</label>
                                            <select id="tag_id" v-model="form.tag_id" class="form-control select2 select2-hidden-accessible" multiple="" style="width: 100%;" tabindex="-1" aria-hidden="true" :class="{ 'is-invalid': form.errors.has('category_id') }">

                                                <option v-for="tag in tags" v-bind:value="tag.id">{{ tag.name }}</option>

                                            </select>
                                            <has-error :form="form" field="category_id"></has-error>
                                        </div>



                                        <div class="form-group">
                                      <textarea v-model="form.short_description" name="short_description" id="short_description"
                                                placeholder="Short description"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('short_description') }"></textarea>
                                            <has-error :form="form" field="short_description"></has-error>
                                        </div>

                                        <div class="form-group">
                                      <textarea v-model="form.long_description" name="long_description" id="summary-ckeditor"
                                                placeholder="Long description"
                                                class="form-control" :class="{ 'is-invalid': form.errors.has('long_description') }"></textarea>
                                            <has-error :form="form" field="long_description"></has-error>
                                        </div>



                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Blog Photo</label>

                                            <div v-if="editMode===true" class="col-md-8" >
                                                <img v-bind:src="'images/blogs/'+form.photo" alt="" height="80px" width="80px">
                                            </div>

                                            <div class="col-md-8" v-if="form.photo.length!==1" >
                                                <img v-bind:src="form.photo" alt="" height="80px" width="80px">
                                            </div>


                                            <div class="col-sm-8">
                                                <input type="file" class="form-control" @change="imageUrl"
                                                       :class="{ 'is-invalid': form.errors.has('photo') }">
                                                <has-error :form="form" field="photo"></has-error>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Position</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" v-model="form.position" v-bind:value="main" class="flat-red"> <small>Main Sec</small>
                                                </label>
                                                <label>
                                                    <input type="checkbox" v-model="form.position" v-bind:value="left" class="flat-red"> <small>Left sec</small>
                                                </label>
                                                <label>
                                                    <input type="checkbox" v-model="form.position" v-bind:value="right" class="flat-red"> <small>Right sec</small>
                                                </label>
                                                <label>
                                                    <input type="checkbox" v-model="form.position" v-bind:value="bottom" class="flat-red"> <small>Bottom sec</small>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Tumbnail</label>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" v-model="form.thumbnail" v-bind:value="main" class="flat-red"> <small>Thumbnail</small>
                                                </label>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Status</label>
                                            <div class="radio">
                                                <label><input type="radio" v-model="form.publication_status" name="publication_status" value="1" class="flat-red" :class="{ 'is-invalid': form.errors.has('publication_status') }"> <small>Published</small></label>
                                                <label><input type="radio" v-model="form.publication_status" name="publication_status" value="0" class="flat-red" :class="{ 'is-invalid': form.errors.has('publication_status') }"> <small>UnPublished</small></label>
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

                emptyData: false,
                editMode: false,
                posts :{},
                categories :{},
                tags :{},
                form: new Form({
                    id:'',
                    title:'',
                    category_id:'',
                    short_description:'',
                    long_description:'',
                    photo:'',
                    author:'',
                    tag_id:'',
                    thumbnail:''

                })
            }
        },
        methods: {


            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#postModal').modal('show');
            },
            editModal(post){
                this.editMode= true;
                $('#postModal').modal('show');
                this.form.fill(post);
            },

            updatepost() {
                this.$Progress.start();
                this.form.put('api/post/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('postOperation');
                    $('#postModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'post has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });
            },


            deletepost(id){
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
                        this.form.delete('api/post/'+id).then(()=> {
                            Fire.$emit('postOperation');
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
            loadposts(){
                axios.get('api/post').then(({ data }) => { this.posts=data })
            },



            createpost(){
                this.$Progress.start();


                // };
                this.form.post('api/post').then(()=> {
                    Fire.$emit('postOperation');
                    $('#postModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'post Created Successfully done'
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
                    this.posts=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadposts();
            Fire.$on('postOperation', () => {
                this.$Progress.start();
                this.loadposts();
                this.$Progress.finish();
            });
            this.$Progress.finish();
        }
    }


</script>


