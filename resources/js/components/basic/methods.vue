<template>
    <div>
        <h1>We can have some data here {{ views }}</h1>
        <button @click="updateView(1)">Increase</button>
        <button @click="updateView(-1)">Decrease</button>
        <br/><br/><br/>
        <button @click="showItem =! showItem"><span v-if="showItem">Hide</span><span v-else>Show</span> Blog</button>

        <div v-if="showItem">
            <!-- Check if blogs not empty -->
            <div v-if="blogs.length">
                <!-- Loop blogs -->
                <div v-for="(blog, i) in blogs" :key="i">
                    <h1>{{ blog.title }}</h1>
                    <p>{{ blog.post }}</p>
                </div>
            </div>
            <!-- Show this dvi if the no blog post -->
            <div v-if="blogs.length == 0">
                <h2>No post</h2>
            </div>
        </div>
        <!-- <div v-else>Item hide</div> -->
        
    </div>
</template>

<script>
export default {
    data(){
        return {
            views:      0,
            blogs:      [], // initialize blogs
            showItem:   true,
        }
    },
    methods: {
        updateView(number){
            this.views += number
        },
    },

    // In reactjs same with the function componentDidMount()
    created() {
        // Call the server to get the views of this blog post...
        this.views = 100;
        // Get the blog post from server
        let posts = [
            {title: 'This is the blog title 1',post: 'This is the blog post 1', id:1},
            {title: 'This is the blog title 2',post: 'This is the blog post 2', id:2},
            {title: 'This is the blog title 3',post: 'This is the blog post 3', id:3},
            {title: 'This is the blog title 4',post: 'This is the blog post 4', id:4},
        ];

        // Assign posts to blogs
        this.blogs = posts
    }
}
</script>