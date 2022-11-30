<template>
    <div class="row" v-for="rowIdx in total_rows">
        <div class="col-md-4 article-container" v-for="article in articles.slice(3 * (rowIdx - 1), 3 * rowIdx)">
            <a :href="!abilityToRead(article) ? '#' : '/blog/' + article.slug" class="link">
                <div class="image">
                    <img v-if="article.image" :src="article.image" style="width: 100%; height: 207px; object-fit: cover;">
                </div>
                <div class="after-image-block">
                    <h3>{{ article.name }}</h3>
                    <p>{{ article.short_description }}</p>
                    <div class="row">
                        <div class="col-md-4 col-4 col-sm-4 col-lg-4 col-xl-4"><i class="fa fa-user" aria-hidden="true"> {{ article.author_name }}</i></div>

                        <div class="offset-md-2 offset-2 offset-sm-2 offset-lg-2 offset-xl-2 col-md-6  col-6 col-sm-6 col-lg-6 col-xl-6" style="text-align: right"><i class="fa fa-eye">{{ article.views }}</i></div>

                    </div>
                    <div class="row">
                        <div class="col-md-4 col-4 col-sm-4 col-lg-4 col-xl-4 posted-date">{{ article.date_in }}</div>
                        <div v-if="abilityToRead(article)" class="offset-md-3 offset-3 offset-sm-3 offset-lg-3 offset-xl-3 col-md-5  col-5 col-sm-5 col-lg-5 col-xl-5"><button class="btn btn-default read_more_btn">Читати більше</button></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div>
        <pagination v-if="pagination.last_page > 1"
                    :pagination="pagination"
                    :offset="7"
                    @paginate="getArticles()">
        </pagination>
    </div>
</template>

<script>


    export default {
        name: "App",
        data() {
            return {
                articles: {},
                api_token:null,
                total_rows:0,
                role:null,
                pagination: {
                    current_page: 1,
                },
                players: [
                    { name : "Player 1"},
                    { name : "Player 2"},
                    { name : "Player 3"},
                    { name : "Player 4"},
                    { name : "Player 5"},
                    { name : "Player 6"},
                    { name : "Player 7"},
                    { name : "Player 8"}
                ]
            }
        },
        mounted() {
            this.getUserApiToken();
            this.getUserRole();
            this.getArticles();
        },
        methods: {
            getArticles() {
                console.log('getArticles')
                let request_url = '/api/articles/get-published-articles?api_token=' + this.api_token;
                if (this.pagination.current_page > 1) {
                    request_url = request_url + "&page=" + this.pagination.current_page;
                }
                axios.get(request_url).then(response => {
                    this.articles = response.data.data;
                    this.total_rows = Math.ceil(this.articles.length / 3);
                    this.pagination = response.data.meta;
                })
            },
            abilityToRead(article) {
                if (this.role == "free" && article.paid_content) {
                    return false;
                }

                return true;
            },
            getUserApiToken() {
                var el = document.querySelector("input[name='api_token']");
                this.api_token = el.value;
            },
            getUserRole() {
                axios.get('/api/get-user-role/' + this.api_token).then(response => {
                    this.role = response.data.role;
                })
            }
        }
    }
</script>

<style scoped>

</style>