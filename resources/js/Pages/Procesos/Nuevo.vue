<style src="vue-multiselect/dist/vue-multiselect.css"></style>
<script setup>
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import VueMultiselect from "vue-multiselect";

const props = defineProps({
    proyecto: Object,
    actores: Array,
});

const allActores = [...props.actores];

const form = useForm({
    nombre_plantilla: "",
    nombre: "",
    descripcion: "",
    entrada: "",
    actores: [],
    image: null,
    proyecto: props.proyecto.id,
});

const submit = () => {
    form.post(route("nuevo-proceso-post"));
};
</script>

<template>
    <Head title="Nuevo proceso" />
    <AuthenticatedLayout>
        <div class="w-full py-10">
            <div class="container mx-auto">
                <h1 class="text-2xl text-gray-600">Nuevo proceso</h1>
                <div
                    class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
                >
                    <form @submit.prevent="submit">
                        <div class="py-3">
                            <InputLabel
                                for="nombre_plantilla"
                                value="Nombre plantilla"
                            />
                            <TextInput
                                id="nombre_plantilla"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nombre_plantilla"
                                required
                                autofocus
                                autocomplete="nombre_plantilla"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.nombre_plantilla"
                            />
                        </div>

                        <div class="py-3">
                            <InputLabel for="Image" value="Imagen" />
                            <TextInput
                                id="image"
                                type="file"
                                class="mt-1 block w-full"
                                @input="form.image = $event.target.files[0]"
                                required
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.image"
                            />
                        </div>

                        <div class="py-3">
                            <InputLabel for="nombre" value="Nombre" />
                            <TextInput
                                id="nombre"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.nombre"
                                required
                                autocomplete="nombre"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.nombre"
                            />
                        </div>

                        <div class="py-3">
                            <InputLabel for="descripcion" value="Descripcion" />
                            <TextAreaInput
                                rows="3"
                                id="descripcion"
                                class="mt-1 block w-full"
                                v-model="form.descripcion"
                                required
                                autocomplete="descripcion"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.descripcion"
                            />
                        </div>
                        <div class="py-3">
                            <InputLabel for="actores" value="Actores" />
                            <VueMultiselect
                                v-model="form.actores"
                                :options="allActores"
                                label="nombre"
                                track-by="id"
                                placeholder="Seleccione multiple actores"
                                :multiple="true"
                            >
                            </VueMultiselect>
                        </div>
                        <div class="py-3">
                            <InputLabel for="entrada" value="Entrada" />
                            <TextAreaInput
                                rows="3"
                                id="entrada"
                                class="mt-1 block w-full"
                                v-model="form.entrada"
                                required
                                autocomplete="entrada"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.entrada"
                            />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                type="submit"
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Registrar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
