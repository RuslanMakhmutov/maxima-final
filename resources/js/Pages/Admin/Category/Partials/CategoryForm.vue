<script setup>
import { useForm } from '@inertiajs/vue3';
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    category: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    title: props.category.title || '',
    _method: props.category.id ? 'PUT' : 'POST', // https://inertiajs.com/file-uploads#multipart-limitations
});

const back = () => {
    window.history.back();
}

const handleSubmit = () => {
    let url;
    if (props.category.id) {
        url = route('admin.categories.update', props.category.id);
    } else {
        url = route('admin.categories.store');
    }

    form.post(url, { forceFormData: true });
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
                placeholder="Введите название категории"
                v-model="form.title"
                required
                autofocus
            />
            <InputError class="mt-2" :message="form.errors.title" />
        </div>

        <div class="flex items-center gap-4">
            <PrimaryButton :disabled="form.processing">Сохранить</PrimaryButton>
            <SecondaryButton @click="back">Отменить</SecondaryButton>
        </div>
    </form>
</template>
