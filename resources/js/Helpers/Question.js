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
            return await axios.get('/api/question'
            ).then(
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
            return await axios.get(`/api/question/${slug}`
            ).then(
                response => {
                    return response.data;
                }
            )
        }

        return await axios.get(`/api/question/${slug}`).then(
            response => response.data
        )
    }

    /**
     * Upvote a question
     * @param {String} slug - question slug
     * @returns response from server
     */
    async voteQuestion(slug, vote_type) {
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.post(`/api/question/${slug}/vote/${vote_type}`
            ).then(
                response => {
                    return response.data;
                }
            ).catch(
                error => {
                    return error.response.data;
                }
            )
        }
    }

    /**
     * Reset vote on a question
     * @param {String} slug - question slug
     * @returns response from server
     */
    async resetVoteQuestion(slug) {
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.delete(`/api/question/${slug}/vote/reset`,
            ).then(
                response => {
                    console.log(response);
                    return response.data;
                }
            ).catch(
                error => {
                    return error.response.data;
                }
            )
        }
    }

    /**
     * 
     */
    async createQuestion(payload){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.post('/api/question', payload
            ).then(
                response => {
                    return response.data;
                }
            ).catch(
                error => {
                    return error.response.data;
                }
            )
        }
    }

    /**
     * Edit question
     * @param {String} slug - question slug
     * @param {Object} payload - question payload
     * @returns response from server
     */
    async editQuestion(slug, payload){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.put(`/api/question/${slug}`, payload
            ).then(
                response => {
                    return response.data;
                }
            ).catch(
                error => {
                    return error.response.data;
                }
            )
        }
    }


}

export default Question = new Question();