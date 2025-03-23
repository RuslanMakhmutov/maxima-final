<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import Textarea from "@/Components/Textarea.vue";
import Select from "@/Components/Select.vue";
import Checkbox from "@/Components/Checkbox.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    categories: {
        type: Array,
        default: () => ([]),
    },

    post: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    title: props.post.title || '',
    description: props.post.description || '',
    content: props.post.content || '',
    category_id: props.post.category_id || null,
    categories: props.post.categories ? props.post.categories.map(i => i.id) : [],
    published: !!props.post.published_at,
    image: null,
    delete_image: false,
    _method: props.post.id ? 'PUT' : 'POST', // https://inertiajs.com/file-uploads#multipart-limitations
});

const back = () => {
    window.history.back();
}

const handleSubmit = () => {
    let url;
    if (props.post.id) {
        url = route('admin.posts.update', props.post.id);
    } else {
        url = route('admin.posts.store');
    }

    form.post(url, {forceFormData: true})
};

</script>

<template>
    <form @submit.prevent="handleSubmit" class="mt-3 space-y-4">
        <!--{{form}}-->

        <div>
            <InputLabel for="title" value="Заголовок" />
            <TextInput
                id="title"
                type="text"
                class="mt-1 block w-full"
                placeholder="Введите название статьи"
                v-model="form.title"
                required
                autofocus
            />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div>
            <label class="flex items-center">
                <Checkbox name="published" v-model:checked="form.published" />
                <span class="ms-2 text-sm text-gray-600">Опубликовать</span>
            </label>
            <InputError class="mt-2" :message="form.errors.published" />
        </div>

        <div>
            <InputLabel for="description" value="Краткое описание статьи" />
            <TextInput
                id="description"
                type="text"
                class="mt-1 block w-full"
                placeholder="Введите краткое описание"
                v-model="form.description"
            />
            <InputError class="mt-2" :message="form.errors.description" />
        </div>

        <div>
            <InputLabel for="text_content" value="Текст статьи" />
            <Textarea
                id="text_content"
                class="mt-1 block w-full"
                placeholder="Введите текст"
                v-model="form.content"
            />
            <InputError class="mt-2" :message="form.errors.content" />
        </div>

        <div>
            <InputLabel for="category_id" value="Главная категория" />
            <Select
                id="category_id"
                class="mt-1 block w-full"
                v-model="form.category_id"
                :options="categories"
                show-empty-option
            />
            <InputError class="mt-2" :message="form.errors.category_id" />
        </div>

        <div>
            <InputLabel for="categories" value="Категории" />
            <Select
                id="categories"
                class="mt-1 block w-full"
                v-model="form.categories"
                :options="categories"
                :size="categories.length"
                multiple
            />
            <InputError class="mt-2" :message="form.errors.categories" />
        </div>

        <div v-if="post.image_url">
            <img :src="post.image_url" :alt="post.title" width="100">

            <label class="flex items-center mt-1">
                <Checkbox name="delete_image" v-model:checked="form.delete_image" />
                <span class="ms-2 text-sm text-gray-600">Удалить изображение?</span>
            </label>
            <InputError class="mt-2" :message="form.errors.published" />
        </div>

        <div>
            <InputLabel for="image" value="Изображение" />
            <input
                @input="form.image = $event.target.files[0]"
                id="image"
                class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                type="file"
                accept="image/*"
            />
            <InputError class="mt-2" :message="form.errors.categories" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Сохранить</PrimaryButton>
            <SecondaryButton @click="back">Отменить</SecondaryButton>
        </div>
    </form>
</template>
