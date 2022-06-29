<template>
  <section>
    <h1>Work in progress ... :D</h1>

    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        <div class="col" v-for="post in postsResponse.data" :key="post.id">
          <div class="product card">
            <img :src="post.cover_image" :alt="post.title" />
            <div class="card-body">
              <h3>{{ post.title }}</h3>
              <p>{{ post.content }}</p>
            </div>
            <div class="card-footer">
              <div class="row">
                <div class="col">
                  <div class="author" v-if="post.user">
                    <h4>Autor</h4>
                    {{ post.user.name }}
                  </div>
                </div>
              </div>
              <span v-if="post.category">
                <strong>Category:</strong>
                {{ post.category.name }}
              </span>

              <div class="tags" v-if="post.tags.length > 0">
                <strong>Tags:</strong>
                <ul>
                  <li v-for="tag in post.tags" :key="tag.id">
                    {{ tag.name }}
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <nav aria-label="Page navigation example ">
      <ul class="pagination justify-content-center mt-5">
        <li class="page-item" v-if="postsResponse.current_page > 1">
          <a class="page-link" href="#" @click.prevent="getAllPost(postsResponse.current_page - 1)">Previous</a>
        </li>
        <li :class="{'page-item' : true, 'active' : page == postsResponse.current_page}" v-for="(page, index) in postsResponse.last_page" :key="index">
          <a class="page-link" href="#" @click.prevent="getAllPost(page)">{{page}}</a>
        </li>
        <li class="page-item" v-if="postsResponse.current_page < postsResponse.last_page">
          <a class="page-link" href="#" @click.prevent="getAllPost(postsResponse.current_page + 1)">Next</a>
        </li>
      </ul>
    </nav>
  </section>
</template>

<script>
export default {
  name: "App",
  components: {},
  mounted() {
    console.log("Mounted Successfully");
    this.getAllPost(1);
    this.getAllCategories();

  },
  methods: {
    getAllPost(postPage) {
        console.log(postPage);
      axios
        .get("/api/posts", {
            params: {
                page: postPage
            }
        })
        .then((response) => {
          console.log(response);
          this.posts = response.data.data;
          this.postsResponse = response.data;
        })
        .catch((e) => {
          console.error(e);
        });
    },
    getAllCategories(){
        axios
        .get('/api/categories')
        .then(response => {
            console.log(response);
            this.categories = response.data
        })
        .catch(e => {
            console.error(e);
        })
    }
  },
  data() {
    return {
      posts: "",
      postsResponse: "",
      categories: ""
    };
  },
};
</script>

<style scoped lang="scss">
h1 {
  color: red;
}
</style>
