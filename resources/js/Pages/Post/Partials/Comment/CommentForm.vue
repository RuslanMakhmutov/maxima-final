<script setup>
import {useForm} from '@inertiajs/vue3';
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import Textarea from "@/Components/Textarea.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    post_id: {
        type: Number,
        required: true,
    },
    parent_id: {
        type: Number,
        default: null,
    },
    comment: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    content: props.comment.content || '',
    parent_id: props.parent_id || '',
    _method: props.comment.id ? 'PUT' : 'POST', // https://inertiajs.com/file-uploads#multipart-limitations
});

const emit = defineEmits(['stored', 'cancelled'])

// const back = () => {
//     window.history.back();
// }

const handleSubmit = () => {
    let url;
    if (props.comment.id) {
        url = route('posts.comments.store', props.post_id);
    } else {
        url = route('posts.comments.store', props.post_id);
    }

    // form.post(url, {
    //     only: ['comments'],
    //     preserveScroll: true,
    //     onSuccess: () => {
    //         form.reset()
    //         emit('stored')
    //     },
    // })

    form.processing = true;

    const data = {
        content: form.content,
        parent_id: form.parent_id || undefined
    }

    axios
        .post(url, data)
        .then((response) => {
            emit('stored', response.data.comment)
            form.reset()
        })
        .catch((err) => {
            console.log(err.response.data.message);
            form.errors = err.response.data.errors || {}
        })
        .finally(() => {
            form.processing = false;
        });
};

const handleCancel = () => {
    form.reset()
    emit('cancelled')
};

</script>

<template>
    <form @submit.prevent="handleSubmit" class="space-y-4">
        <!--{{ form }}-->

        <div>
            <Textarea
                v-model="form.content"
                id="text_content"
                class="mt-1 block w-full"
                placeholder="Введите комментарий..."
            />
            <InputError class="mt-2" :message="form.errors.content ? form.errors.content[0] : ''"/>
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Отправить</PrimaryButton>

            <SecondaryButton
                v-if="parent_id"
                @click="handleCancel"
            >Отменить</SecondaryButton>
        </div>
    </form>
</template>
