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
                        <h3 class="card-title">carousel Management</h3>

                        <div class="card-tools">

                            <div><a href="#" @click="createModal" class="btn btn-success">Add new <i class="fas fa-user-plus"></i></a></div>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody><tr>
                                <th>Sl no:</th>
                                <th>carousel name</th>
                                <th>carousel photo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>


                            <div hidden>
                                {{ $i=1 }}
                            </div>
                            <tr v-for="carousel in carousels.data">
                                <td>{{ $i++ }}</td>
                                <td>{{ carousel.carousel_caption }}</td>
                                <td><img v-bind:src="'images/carousel/'+carousel.photo" alt="" height="80px" width="80px"></td>
                                <td v-if="carousel.publication_status===1">Published</td>
                                <td v-if="carousel.publication_status===0">UnPublished</td>

                                <td>
                                    <a class="btn btn-secondary" href="#" @click="editModal(carousel)"><i class="fas fa-user-edit"></i></a>
                                    <a class="btn btn-danger" href="#" @click="deletecarousel(carousel.id)"><i class="fas fa-trash"></i></a>

                                </td>
                            </tr>

                            </tbody></table>
                    </div>
                    <div class="card-footer">
                        <pagination :data="carousels" @pagination-change-page="getResults"></pagination>
                    </div>

                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>



        </div>


        <div class="container">
            <div class="col-md-9 col-md-offset-3">
                <div class="modal fade" id="carouselModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" v-show="editMode">Update carousel Data</h5>
                                <h5 class="modal-title" v-show="!editMode">Create carousel data</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <form @submit.prevent="editMode ? updatecarousel() : createcarousel() " enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <input v-model="form.carousel_caption" type="text" name="carousel_caption"
                                                   placeholder="carousel name"
                                                   class="form-control" :class="{ 'is-invalid': form.errors.has('carousel_caption') }">
                                            <has-error :form="form" field="carousel_caption"></has-error>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Carousel Photo</label>

                                            <div v-if="editMode===true" class="col-md-8" >
                                                <img v-bind:src="'images/carousel/'+form.photo" alt="" height="80px" width="80px">
                                            </div>

                                            <div class="col-md-8" >
                                                <img v-bind:src="form.photo" alt="" height="80px" width="80px">
                                            </div>


                                            <div class="col-sm-8">
                                                <input type="file" class="form-control" @change="imageUrl"
                                                       :class="{ 'is-invalid': form.errors.has('photo') }">
                                                <has-error :form="form" field="photo"></has-error>
                                            </div>
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
                carousels :{},
                form: new Form({
                    id:'',
                    carousel_caption:'',
                    photo:'',
                    publication_status:''
                })
            }
        },
        methods: {



            imageUrl(e) {
                let file = e.target.files[0];
                console.log(file);
                let reader = new FileReader();

                reader.onload = (file) => {
                    this.form.photo = file.target.result;
                    console.log(this.form.photo)
                    // rebuild cropperjs with the updated source
                    // this.$refs.cropper.replace(event.target.result)
                };
                reader.readAsDataURL(file)


            },

            getResults(page = 1) {
                axios.get('api/carousel?page=' + page)
                    .then(response => {
                        this.permissions = response.data;
                    });
            },

            createModal(){
                this.editMode= false;
                this.form.reset();
                $('#carouselModal').modal('show');
            },
            editModal(carousel){
                this.editMode= true;
                $('#carouselModal').modal('show');
                this.form.fill(carousel);
            },

            updatecarousel() {
                this.$Progress.start();
                this.form.put('api/carousel/'+this.form.id).then(()=> {
                    this.$Progress.start();
                    Fire.$emit('carouselOperation');
                    $('#carouselModal').modal('hide');
                    Swal.fire(
                        'Updated!',
                        'carousel has been Updated.',
                        'success'
                    )
                    this.$Progress.finish();
                });
            },


            deletecarousel(id){
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
                        this.form.delete('api/carousel/'+id).then(()=> {
                            Fire.$emit('carouselOperation');
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
            loadcarousels(){
                axios.get('api/carousel').then(({ data }) => { this.carousels=data })
            },



            createcarousel(){


                this.$Progress.start();

                this.form.post('api/carousel').then(()=> {
                    Fire.$emit('carouselOperation');
                    $('#carouselModal').modal('hide');
                    Toast.fire({
                        type: 'success',
                        title: 'carousel Created Successfully done'
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
                    this.carousels=data;
                }).catch(()=> {
                    console.log('not working')
                });
            });

            this.loadcarousels();
            Fire.$on('carouselOperation', () => {
                this.$Progress.start();
                this.loadcarousels();
                this.$Progress.finish();
            });
            this.$Progress.finish();
        }
    }
</script>
