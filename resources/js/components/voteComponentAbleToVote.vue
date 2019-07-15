<template>
    <div>
        <div v-if="Number.isInteger(upvotes)" class="votingAnimationClass" v-on:click="vote('upvote')">
            <i class="icon-plus-squared"></i>{{upvotes}}
        </div>
        <div v-if="Number.isInteger(downvotes)" v-on:click="vote('downvote')">
            <i class="icon-minus-squared"></i>{{downvotes}}
        </div>
    </div>
</template>

<script>
export default {

    data: function() {
        return {
            upvotes: null,
            downvotes: null
        }
    },

    props: {
        postId: null
    },

    methods: {
        vote: function(type)
        {
            let url = '/downvote-post'

            if(type === 'upvote')
            {
                  url = '/upvote-post'
            }

            axios.post(url, {
              postId: this.postId,
            }).then(response => {
                response.data.success? this.success = response.data.success :
                this.error = response.data.error;
                this.getPosts();
            }).catch(error => console.log(error));
        },

        getPosts: function() {
            axios.get('/get-post-votes/', {
              params: {
                  postId: this.postId
              },
            }).then(response =>
              {this.upvotes = response.data.upvotes; this.downvotes = response.data.downvotes;}
            );
        }
    },

    mounted: function() {
        this.getPosts();
    }
}

</script>

<style scoped>
.icon-plus-squared:hover:before {
    color: #44FF9F;
    cursor: pointer;
}

.icon-minus-squared:hover:before {
    color: 	#fe365e;
    cursor: pointer;
}

.votingAnimation {
    animation-durations: 2s;
    animation-name: votingAnimation;
    animation-direction: alternate;
}

@keyframes .votingAnimation {
    from {
        transform: translateY(0);
    }

    to {
      transform: transalteY(-50%);
    }
}

</style>
