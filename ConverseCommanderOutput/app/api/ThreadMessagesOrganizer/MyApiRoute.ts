import {ApiResponse} from "@/lib/ApiResponse";
import withJWTAuthUser from "@/middlewares/withJWTAuthUser";
import ThreadReportController from "@/services/ConverseCrawler/Controllers/ThreadReportController";

export default withJWTAuthUser(
    async function GenerateThreadReport(req, res) {
        switch (req.method) {
            case 'POST':

                const controller = new ThreadReportController(req, res)
                return await controller.generateThreadOverviewReport()

            default:
                return ApiResponse.methodNotAllowed(res, req)
        }
    }
)
