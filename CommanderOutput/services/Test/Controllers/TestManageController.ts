import {NextApiRequest, NextApiResponse} from "next";
import ApiController from "@/core/ApiController";
import UserRepository from "@/services/UserManager/Repositories/UserRepository";
import ApiResponse from "@/lib/http/ApiResponse";

interface ResponseDataInterface {
}


export default class TestManageController extends ApiController {
    private userRepo: UserRepository

    constructor(
        req: NextApiRequest,
        res: NextApiResponse<ResponseDataInterface>,
    ) {
        super(req, res)

        this.userRepo = new UserRepository()
    }

    public async getUsers() {
        try {

            const users = await this
                .userRepo
                .findAll()

            return ApiResponse.success(users)

        }catch (e) {
            return ApiResponse.error(e)
        }
    }

    public async getUser(id: number) {
        try {

            const user = await this
                .userRepo
                .findById(id)

            return ApiResponse.success(user)

        }catch (e) {
            return ApiResponse.error(e)
        }
    }
}
