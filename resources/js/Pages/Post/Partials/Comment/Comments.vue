<script setup>
import CommentForm from "@/Pages/Post/Partials/Comment/CommentForm.vue";
import CommentsListItem from "@/Pages/Post/Partials/Comment/CommentsListItem.vue";
import {nextTick, onBeforeUnmount, ref} from "vue";

const props = defineProps({
    comments: {
        type: Array,
        default: () => ([]),
    },
    post: {
        type: Object,
        default: () => ({}),
    },
})

const reply_id = ref(null)

const setupListeners = () => {
    Echo.channel(`post.${props.post.id}.comments`)
        // .listen('.comment.created', (e) => {
        .listen('CommentStoredEvent', (comment) => {
            insertStored(comment)
        })
        .listen('CommentDeletedEvent', ({id}) => {
            setDeleted(id)
        })
}

const deleteListeners = () => {
    Echo.leaveChannel(`post.${props.post.id}.comments`);
    // Echo.leave(`post.${props.post.id}.comments`);
}

setupListeners()

onBeforeUnmount(() => {
    deleteListeners();
})

const handleStored = (comment) => {
    cancelReply()

    insertStored(comment)

    nextTick(() => {
        document.getElementById(`comment-${comment.id}`).scrollIntoView({block: 'center', behavior: 'smooth'});
    })
}

const insertStored = (comment) => {
    if (comment.parent_id) {
        const insertAfterKey = getIndexOfLastReply(comment.parent_id)

        if (insertAfterKey !== -1) {
            props.comments.splice(insertAfterKey + 1, 0, comment);
        } else {
            props.comments.push(comment);
        }
    } else {
        props.comments.push(comment);
    }
}

const handleDeleted = () => {
    cancelReply()
}

const setDeleted = (id) => {
    const index = props.comments.findIndex(el => el.id === id)
    if (index !== -1) {
        props.comments[index].is_deleted = true
    }
}

const cancelReply = () => {
    reply_id.value = null
}

const getIndexOfLastReply = (id) => {
    // ищем индекс последнего ответа на комментарий с данным id
    const indexOfLastReply = props.comments.findLastIndex(el => el.parent_id === id)

    // если не нашли ни одного ответа
    if (indexOfLastReply === -1) {
        // возвращаем индекс последнего комментария в рекурсии
        return props.comments.findIndex(el => el.id === id)
    }

    // рекурсивно ищем индекс последнего ответа
    return getIndexOfLastReply(props.comments[indexOfLastReply].id)
}
</script>

<template>

    <section class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
            <div class="flex flex-col">
                <div class="py-2 px-4 sm:py-3 sm:px-6 flex justify-between items-center">
                    <h2 class="text-lg lg:text-2xl font-bold text-gray-900 dark:text-white">Комментарии ({{ comments.length }})</h2>
                </div>

                <div>
                    <CommentsListItem
                        v-for="(comment, index) in comments"
                        :key="comment.id"
                        :comment="comment"
                        :index="index"
                        :post_id="post.id"
                        :reply_id="reply_id"
                        @reply="(id) => reply_id = id"
                        @stored="handleStored"
                        @cancelled="cancelReply"
                        @deleted="handleDeleted"
                    />
                </div>

                <template v-if="$page.props.auth.user">
                    <CommentForm
                        v-if="!reply_id"
                        :post_id="post.id"
                        class="p-4 sm:p-6"
                        @stored="handleStored"
                    />
                </template>
                <div v-else class="p-4 sm:p-6">Авторизуйтесь для отправки комментариев</div>
            </div>
        </div>
    </section>
</template>
