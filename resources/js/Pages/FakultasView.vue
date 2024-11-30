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
    import TableFakultas from '@/Components/Fakultas/TableFakultas.vue'
    import FormFakultas from '@/Components/Fakultas/FormFakultas.vue'

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
            <SectionTitleLineWithButton :icon="mdiBallotOutline" title="Form Fakultas" main>
            </SectionTitleLineWithButton>
            <FormFakultas />
        </SectionMain>
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiTableBorder" title="Daftar Fakultas" main>
            </SectionTitleLineWithButton>
            <CardBox>
                <TableFakultas :data="data"/>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
