<script setup>
import Pagination from "../Pagination.vue";
import AnswersContent from "./AnswersContent.vue";
import useModal from "../../Composable/useModal";
import { reactive } from "vue";
import UpdateAnswer from "./UpdateAnswer.vue";

const { showModal, hideModal, modalTitle, Modal } = useModal(
    "#update-answer-modal"
);

defineProps({
    answers: {
        type: Object,
        required: true,
    },
});

const editingAnswer = reactive({
    body: "",
    question_id: "",
    id: "",
});

const editAnswer = (payload) => {
    modalTitle.value = "Editing Answer";

    editingAnswer.body = payload.body;
    editingAnswer.question_id = payload.question_id;
    editingAnswer.id = payload.id;

    showModal();
};
</script>

<template>
    <div class="d-flex justify-content-between align-items-center">
        <h2 class="mt-4 answer-header">{{ answers.meta.total }} Answers</h2>
        <Pagination :meta="answers.meta" />
    </div>
    <div class="answer-content mt-4">
        <AnswersContent
            v-for="answer in answers.data"
            :key="answer.id"
            :answer="answer"
            @edit="editAnswer"
        />
    </div>
    <Modal
        id="update-answer-modal"
        :title="modalTitle"
        size="large"
        @hidden="editingAnswer.body"
    >
        <UpdateAnswer
            :answer="editingAnswer"
            @success="hideModal"
            v-if="editingAnswer.body"
        />
    </Modal>
</template>
