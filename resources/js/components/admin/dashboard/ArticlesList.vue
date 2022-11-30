<template>
    <div class="box-body">
        <div class="mb-2">
            <button id="show-modal" class="btn btn-primary" @click.prevent="addNewArticle">Додати</button>
        </div>

        <table id="example2" class="table table-bordered table-striped datatable">
            <thead>
            <tr>
                <th>ID</th>
                <th>Зображення</th>
                <th>Короткий опис</th>
                <th>Автор</th>
                <th>Дата створення</th>
                <th>Дії</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="article in articles">
                <td>{{ article.id }}</td>
                <td>
                    <img v-if="article.image" :src="article.image" style="width: 150px;">
                </td>
                <td width="500">{{article.short_description}}</td>
                <td>{{article.author_name}}</td>
                <td>{{article.created_at}}</td>
                <td>
                    <a href="#" class="fa fa-edit" title="Редагувати" @click.prevent="editArticle(article)"></a>
                    <a href="#" class="btn"><i class="fa fa-trash" @click.prevent="deleteArticle(article)"></i></a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <pagination v-if="pagination.last_page > 1"
                :pagination="pagination"
                :offset="7"
                @paginate="getArticles()">
    </pagination>
    <div class="modal fade bd-example-modal" id="deleteArticalModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel2">
                        Ви впевнені, що хочете видалити цю новину?
                    </h5>
                </div>
                <form ref="form" @submit.prevent="submitDeleteArticle">
                    <input type="hidden" v-model="fields.id">
                    <div class="modal-body">
                        <div class="modal-footer">
                            <button type="button"  data-dismiss="modal" @click.prevent="closeModal" class="btn btn-secondary">Ні</button>
                            <button type="submit" class="btn btn-primary">Так</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg" id="articleFormModal" data-backdrop="static" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">
                        <span v-if="editing">Редагування статті</span>
                        <span v-else>Додавання нової статті</span>
                    </h5>
                    <button type="button" class="close" @click.prevent="closeModal" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form ref="form" class="article-form" @submit.prevent="submit">
                    <input type="hidden" v-model="fields.id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="imagePreviewWrapper" :style="{ 'background-image': `url(${previewImage})` }" @click="selectImage"> </div>

                                <input ref="fileInput" :class="{'is-invalid': errors.image }" name="image" type="file" @input="pickFile" @change="handleOnChange">
                                <span class="invalid-feedback">{{ errors.image }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name">Назва</label>
                                <input  name="name" type="text" v-model="fields.name" class="form-control" :class="{'is-invalid': errors.name }" id="name"
                                        aria-describedby="nameHelp" placeholder="Введіть ім'я статті" >
                                <span class="invalid-feedback">{{ errors.name }}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="title">Тайтл</label>
                                <input name="title" type="text" v-model="fields.title" class="form-control" :class="{'is-invalid': errors.title }" id="title"
                                       aria-describedby="nameHelp" placeholder="Введіть тайтл" >
                                <span class="invalid-feedback">{{ errors.title }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="slug">Slug</label>
                                <input  name="slug" type="text" v-model="fields.slug" pattern="^[a-zA-Z0-9,\s]+$" class="form-control" :class="{'is-invalid': errors.slug }" id="slug"
                                        aria-describedby="nameHelp" placeholder="Використовуйте символи " >
                                <span class="invalid-feedback">{{ errors.slug }}</span>
                            </div>
                            <div class="col-md-6">
                                <label for="author">Автор</label>
                                <select class="form-control" v-model="fields.user_id" :class="{'is-invalid': errors.user_id }" name="user_id">
                                    <option v-for="user in users" :selected="user.id === fields.user_id" :value="user.id">{{ user.name }}</option>
                                </select>
                                <span class="invalid-feedback">{{ errors.user_id }}</span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="short_description">Короткий опис</label>
                            <textarea class="form-control" name="short_description" :class="{'is-invalid': errors.short_description }" id="short_description" v-model="fields.short_description"></textarea>
                            <span class="invalid-feedback">{{ errors.short_description }}</span>
                        </div>

                        <div class="form-group">
                            <label for="description">Опис</label>
                            <!--<textarea class="form-control" name="description" id="description" v-model="fields.description"></textarea>-->
                            <editor
                                    api-key="abflvrwimzdaijmqysinzyon39kp2cm69r88q3l615farduo"
                                    :init="{
      menubar: false,
      plugins: 'lists link image emoticons',
      toolbar: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image emoticons'
    }" name="description" id="description" v-model="fields.description"
                            />
                            <span class="invalid-feedback">{{ errors.description }}</span>
                        </div>
                        <div class="form-check">
                            <label>Дата опублікування:</label>
                            <div class="input-group date">
                                <input type="date" name="date_in" v-model="fields.date_in" class="form-control pull-right date_in" id="datepicker">
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="paid_content" v-model="fields.paid_content" :checked="fields.paid_content">
                            <label for="paid_content">Платний контент</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="published" v-model="fields.published" :checked="fields.published">
                            <label for="published">Опублікувати</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"  data-dismiss="modal" @click.prevent="closeModal" class="btn btn-secondary">Відміна</button>
                        <button type="submit" class="btn btn-primary">Зберегти</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<script>
    import Editor from '@tinymce/tinymce-vue'
    // import uploadImage from '/resources/js/components/filePreview.vue'

    export default {
        name: 'App',
        components: {
            'editor': Editor
            // 'pagination': vuePagination,
        },
        data() {
            return {
                articles:null,
                api_token:null,
                users:null,
                image:null,
                fields: {},
                success: false,
                showModal: false,
                selectedImage: null,
                previewImage: '/dist/img/upload_image.jpg',
                editing: false,
                pagination: {
                    current_page: 1,
                },
                errors: {}
            }
        },
        mounted() {
            this.getUserApiToken();
            this.getArticles();
            this.getUsers();
        },
        methods: {
            view(page = 1) {

            },
            selectImage () {
                this.$refs.fileInput.click()
            },
            pickFile () {
                let input = this.$refs.fileInput
                let file = input.files
                if (file && file[0]) {
                    let reader = new FileReader
                    reader.onload = e => {
                        this.previewImage = e.target.result
                    }
                    reader.readAsDataURL(file[0])
                    this.$emit('input', file[0])
                }
            },
            getUserApiToken() {
                this.api_token = $('input[name="api_token"]').val();
            },

            submitDeleteArticle() {
                axios.delete('/api/admin/articles/' + this.fields.id, this.fields).then(response => {
                    this.clearModalFields();
                    this.success = true;
                    this.errors = {};
                    this.getArticles();
                    this.closeModal();
                }).catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                    this.success = false;
                    console.log('Error')
                });
            },
            submit() {
                let fd = new FormData();
                fd.append("image", this.selectedImage);
                fd.append("slug", this.fields.slug);
                fd.append("name", this.fields.name);
                fd.append("title", this.fields.title);
                fd.append("short_description", this.fields.short_description);
                fd.append("description", this.fields.description);
                fd.append("date_in", this.fields.date_in);
                fd.append("published", this.fields.published);
                fd.append("paid_content", this.fields.paid_content);
                fd.append("user_id", this.fields.user_id );
                console.log(this.fields)
                if (!this.editing) {
                    axios.post('/api/admin/articles', fd).then(response => {
                        this.clearModalFields();
                        this.success = true;
                        this.errors = {};
                        this.getArticles();
                        this.closeModal();
                    }).catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        this.success = false;
                        console.log('Error')
                    });
                } else {
                    axios.post('/api/admin/articles/post-update/' + this.fields.id, fd).then(response => {
                        this.clearModalFields();
                        this.success = true;
                        this.errors = {};
                        this.getArticles();
                        this.closeModal();
                    }).catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                        this.success = false;
                        console.log('Error')
                    });
                }
            },
            handleOnChange(e) {
                this.selectedImage = e.target.files[0];
            },
            deleteArticle(article) {
                this.fields.id = article.id;
                $('#deleteArticalModal').modal('show');
            },
            editArticle(article) {
                this.previewImage = article.image ? article.image : '/dist/img/upload_image.jpg';
                this.editing = true;
                this.fields.id = article.id;
                this.fields.name = article.name;
                this.fields.title = article.title;
                this.fields.slug = article.slug;
                this.fields.short_description = article.short_description;
                this.fields.description = article.description;
                this.fields.user_id = article.user_id;
                this.fields.paid_content = article.paid_content;
                this.fields.published = article.published;
                this.fields.date_in = article.date_in;
                $('#articleFormModal').modal('show');
            },
            addNewArticle() {
                this.editing = false;
                this.clearModalFields();
                $('#articleFormModal').modal('show');
            },
            closeModal() {
                $('.modal').modal('hide');
            },
            getArticles() {
                let request_url = '/api/admin/articles?api_token=' + this.api_token;
                if (this.pagination.current_page > 1) {
                    request_url = request_url + "&page=" + this.pagination.current_page;
                }
                axios.get(request_url).then(response => {
                    this.articles = response.data.data;
                    this.pagination = response.data.meta;
                })
            },
            clearModalFields() {
                this.fields = {};
                this.previewImage = '/dist/img/upload_image.jpg';
                tinyMCE.activeEditor.setContent('');
            },
            getUsers() {
                axios.get('/api/admin/users').then(response => {
                    this.users = response.data.data;
                    console.log(this.users)
                })
            },
        }
    }
</script>

<style>
    .imagePreviewWrapper {
        width: 250px;
        height: 250px;
        display: block;
        cursor: pointer;
        margin: 0 auto 30px;
        background-size: cover;
        background-position: center center;
    }
</style>