<style src="vue-multiselect/dist/vue-multiselect.css"></style>

<script setup>
import { ref, onBeforeMount } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextAreaInput from "@/Components/TextAreaInput.vue";
import VueMultiselect from "vue-multiselect";

const props = defineProps({
    proyecto: Object,
    casoUso: Object,
});
const allRequerimientos = [...props.proyecto.requerimientos];

const label = ref("Nuevo");

const form = useForm({
    id: -1,
    clave: "",
    descripcion: "",
    requerimientos: [],
    proyecto: props.proyecto.id,
});

const submit = () => {
    if (label.value == "Nuevo") {
        form.post(route("nuevo-caso-uso-post"));
    } else {
        form.post(route("update-caso-uso-post", { casoUso: form.id }));
    }
};

onBeforeMount(() => {
    const caso_uso = props.casoUso;
    if (caso_uso) {
        label.value = "Editar";
        form.id = caso_uso.id;
        form.clave = caso_uso.clave;
        form.descripcion = caso_uso.descripcion;
        form.requerimientos = caso_uso.requerimientos;
    }
});
</script>
<template>
    <Head title="Nuevo proyecto" />
    <AuthenticatedLayout>
        <div class="w-full py-10">
            <div class="container mx-auto">
                <h1 class="text-2xl text-gray-600">{{ label }} caso de uso</h1>
                <div
                    class="w-full mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg"
                >
                    <form @submit.prevent="submit">
                        <div>
                            <InputLabel for="clave" value="Clave" />
                            <TextInput
                                id="clave"
                                type="text"
                                class="mt-1 block w-full"
                                v-model="form.clave"
                                required
                                autofocus
                                autocomplete="clave"
                            />
                            <InputError
                                class="mt-2"
                                :message="form.errors.clave"
                            />
                        </div>

                        <div class="mt-4">
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
                            <InputLabel
                                for="requerimientos"
                                value="Requerimientos"
                            />
                            <VueMultiselect
                                v-model="form.requerimientos"
                                :options="allRequerimientos"
                                label="descripcion"
                                track-by="id"
                                placeholder="Seleccione multiple requerimientos"
                                :multiple="true"
                            >
                            </VueMultiselect>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton
                                type="submit"
                                class="ml-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Guardar
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
