/**
 * Question helper class
 * @class
 */
import AppStorage from "./AppStorage";
import User from "./User";

class Question {
    /**
     * GET all questions
     * @param {Object} req - Express request object
     */
    async getAllQuestions() {
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.get('/api/question', {
                headers: {
                    Authorization: `Bearer ${AppStorage.getToken()}`
                }
            }).then(
                response => {
                    return response.data;
                }
            )
        }

        return await axios.get('/api/question').then(
            response => response.data
        )
    }

    /**
     * GET question by slug
     * @param string slug
     * @returns response from server
     */
    async getQuestionBySlug(slug) {
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.get(`/api/question/${slug}`, {
                headers: {
                    Authorization: `Bearer ${AppStorage.getToken()}`
                }
            }).then(
                response => {
                    return response.data;
                }
            )
        }

        return await axios.get(`/api/question/${slug}`).then(
            response => response.data
        )
    }




}

export default Question = new Question();