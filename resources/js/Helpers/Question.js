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

    /**
     * Delete question
     * @param {String} slug - question slug
     * @returns response from server
     */
    deleteQuestion(slug){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return axios.delete(`/api/question/${slug}`
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
     * Create a reply
     * @param {String} slug - question slug
     * @param {string} reply - reply content
     * @returns response from server
     */
    async createReply(slug, reply){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.post(`/api/question/${slug}/reply`, {
                body: reply
            }).then(
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
     * Delete reply
     * @param {String} slug - question slug
     * @param {String} reply_id - reply id
     * @returns response from server
     */
    async deleteReply(slug, reply_id){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.delete(`/api/question/${slug}/reply/${reply_id}`
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
     * Like reply
     * @param {Int} reply_id - reply id
     * @returns response from server
     */
    async likeReply(reply_id){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.post(`/api/like/${reply_id}`
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

    async unlikeReply(reply_id){
        // if user is logged in use token 
        if(User.checkIfLoggedIn()){
            return await axios.delete(`/api/like/${reply_id}`
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