<script setup>
import { ref, watch } from "vue";
import { Head, Link, useForm } from "@inertiajs/inertia-vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Container from "@/Components/Requerimientos/Container.vue";

const props = defineProps({
    proyecto: Object,
});

const requerimientos = ref([...props.proyecto.requerimientos]);

const requerimientos_funcionales = ref([
    ...requerimientos.value.filter((r) => r.is_funcional),
]);

const requerimientos_no_funcionales = ref([
    ...requerimientos.value.filter((r) => !r.is_funcional),
]);

watch(requerimientos, () => {
    requerimientos_funcionales.value = [...requerimientos.value].filter(
        (r) => r.is_funcional
    );

    requerimientos_no_funcionales.value = [...requerimientos.value].filter(
        (r) => !r.is_funcional
    );
});

const nuevoRequerimiento = () => {
    window.location.href = route("nuevo-requerimiento", {
        proyecto: props.proyecto.id,
    });
};

const back = () => {
    window.location.href = route("visualizar-proyecto", {
        proyecto: props.proyecto.id,
    });
};

const deleteRequerimiento = (id) => {
    requerimientos.value = requerimientos.value.filter((r) => r.id !== id);
};
</script>

<template>
    <Head title="Nuevo proyecto" />
    <AuthenticatedLayout>
        <div class="container mx-auto mt-10">
            <div class="py-3 flex gap-2">
                <PrimaryButton @click="back"> Atras </PrimaryButton>
                <PrimaryButton @click="nuevoRequerimiento">
                    Nuevo requerimiento
                </PrimaryButton>
            </div>

            <container
                class="mt-5"
                title="Requerimiento funcionales"
                @delete-requerimiento="deleteRequerimiento"
                :requerimientos="requerimientos_funcionales"
            />
            <container
                class="mt-5"
                title="Requerimientos no funcionales"
                @delete-requerimiento="deleteRequerimiento"
                :requerimientos="requerimientos_no_funcionales"
            />
        </div>
    </AuthenticatedLayout>
</template>
