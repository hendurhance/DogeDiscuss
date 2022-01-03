/**
 * CryptoReq helper class
 * @class CryptoReq
 * @namespace Helpers
 * 
 */
class CryptoReq {
    /**
     * Get News from /api/news/doge
     * @returns response from server
     */
    async getNews() {
        return await axios.get('/api/news/doge').then(
            response => response.data
        )
    }
}



export default CryptoReq = new CryptoReq();