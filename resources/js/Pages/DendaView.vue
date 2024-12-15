<script setup>
    import {
        mdiBallotOutline,
        mdiTableBorder
    } from '@mdi/js'
    import SectionMain from '@/Components/SectionMain.vue'
    import CardBox from '@/Components/CardBox.vue'
    import LayoutAuthenticated from '@/Layouts/LayoutAuthenticated.vue'
    import SectionTitleLineWithButton from '@/Components/SectionTitleLineWithButton.vue'
    import {
        Head
    } from '@inertiajs/vue3'
    import TableDenda from '@/Components/Denda/TableDenda.vue'
    // import FormFakultas from '@/Components/Fakultas/FormFakultas.vue'

    defineProps({
    data: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <LayoutAuthenticated>

        <Head title="form" />
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiTableBorder" title="Daftar Denda" main>
            </SectionTitleLineWithButton>
            <CardBox>
                <TableDenda :data="data"/>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
