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
    import TableProdi from '@/Components/Prodi/TableProdi.vue'
    import FormProdi from '@/Components/Prodi/FormProdi.vue'

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
            <SectionTitleLineWithButton :icon="mdiBallotOutline" title="Form Prodi" main>
            </SectionTitleLineWithButton>
            <FormProdi />
        </SectionMain>
        <SectionMain>
            <SectionTitleLineWithButton :icon="mdiTableBorder" title="Daftar Prodi" main>
            </SectionTitleLineWithButton>
            <CardBox>
                <TableProdi :data="data"/>
            </CardBox>
        </SectionMain>
    </LayoutAuthenticated>
</template>
