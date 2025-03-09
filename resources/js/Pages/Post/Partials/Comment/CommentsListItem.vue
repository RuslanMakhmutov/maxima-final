<script setup>
import {Link} from '@inertiajs/vue3';
import {computed, ref} from "vue";
import CommentForm from "@/Pages/Post/Partials/Comment/CommentForm.vue";
const props = defineProps({
    comment: {
        type: Object,
        default: () => ({}),
    },
    post_id: {
        type: Number,
        required: true,
    },
    reply_id: {
        type: Number,
        default: null,
    },
    index: {
        type: Number,
    },
})

const classes = computed(() => {
    let classes = [];

    switch (props.comment.level) {
        case 2:
            classes.push('ml-4 sm:ml-8');
            break;
        case 3:
            classes.push('ml-8 sm:ml-16');
            break;
        case 4:
            classes.push('ml-12 sm:ml-24');
            break;
        case 5:
            classes.push('ml-16 sm:ml-32');
            break;
    }

    if (props.comment.is_deleted) {
        classes.push('bg-gray-200 text-gray-400')
    } else {
        classes.push('bg-white')
    }

    return classes.join(' ')
})

const emit = defineEmits(['stored', 'reply', 'cancelled', 'deleted'])

const processing = ref(false)

const handleStored = (comment) => {
    emit('stored', comment)
}

const handleCancelled = () => {
    emit('cancelled')
}

const handleReplyClick = () => {
    emit('reply', props.comment.id)
}

const handleDeleteClick = () => {
    processing.value = true

    axios
        .delete(route('comments.delete', props.comment.id))
        .then(() => {
            emit('deleted')

            props.comment.is_deleted = true
        })
        .catch((err) => {
            console.log(err.response.data.message);
        })
        .finally(() => {
            processing.value = false
        });
}
</script>

<template>
    <article
        :id="`comment-${comment.id}`"
        class="py-3 px-4 sm:px-6 mb-3 last:mb-0 text-base border-t last:border-b border-gray-200"
        :class="classes"
    >
        <template v-if="comment.is_deleted">
            Комментарий удалён
        </template>
        <template v-else>
            <footer class="flex space-x-4 items-center mb-2">
                <a
                    :href="`#comment-${comment.id}`"
                    class="flex items-center"
                >
                    <!--<span class="inline-flex items-center mr-3 text-sm text-red-600 dark:text-white font-semibold">-->
                    <!--    &lt;!&ndash;root_id:{{ comment.root_id }}&ndash;&gt;-->
                    <!--    {{index}}-->
                    <!--</span>-->
                    <!--<span class="inline-flex items-center mr-3 text-sm text-orange-600 dark:text-white font-semibold">parent_id:{{ comment.parent_id || 'null' }}</span>-->
                    <!--<span class="inline-flex items-center mr-3 text-sm text-blue-600 dark:text-white font-semibold">id:{{ comment.id }}</span>-->
                    <span
                        class="inline-flex items-center mr-3 text-sm dark:text-white font-semibold"
                        :class="[{
                            'text-blue-600 font-bold': $page.props.auth.user && $page.props.auth.user.id === comment.user.id,
                            'text-gray-900': $page.props.auth.user && $page.props.auth.user.id !== comment.user.id,
                        }]"
                    >{{ comment.user.name }}</span>
                    <span class="text-sm text-gray-600 dark:text-gray-400">
                        <time :datetime="comment.created_at">
                            {{ new Date(comment.created_at).toLocaleDateString() }} {{ new Date(comment.created_at).toLocaleTimeString() }}
                        </time>
                    </span>
                </a>
                <button
                    v-if="$page.props.auth.isAdmin"
                    @click="handleDeleteClick"
                    type="button"
                    class="text-sm dark:text-white font-semibold transition"
                    :disabled="processing"
                    :class="{
                        'text-red-200': processing,
                        'text-red-600 hover:text-red-500 hover:underline': !processing,
                    }"
                >
                    Удалить
                </button>
            </footer>

            <p
                class="text-gray-500 dark:text-gray-400"
                v-for="(p, key) in comment.content.split(/[\r\n]+/)"
                :key="key"
            >{{ p }}</p>


            <template v-if="$page.props.auth.user">
                <CommentForm
                    v-if="reply_id === comment.id"
                    :post_id="post_id"
                    :parent_id="comment.id"
                    @stored="handleStored"
                    @cancelled="handleCancelled"
                    class="mt-6"
                />
                <div
                    v-else
                    class="flex items-center mt-4 space-x-4"
                >
                    <button
                        @click="handleReplyClick"
                        type="button"
                        class="flex items-center text-sm text-gray-500 hover:underline dark:text-gray-400 font-medium"
                    >
                        <svg class="mr-1.5 w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 18">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 8h2m6-3h2m-5 3h6m2-7H2a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3v5l5-5h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1Z"/>
                        </svg>
                        Ответить
                    </button>
                </div>
            </template>
        </template>
    </article>
</template>
