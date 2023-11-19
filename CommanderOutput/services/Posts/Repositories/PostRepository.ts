import PrismaBaseRepository from "@/database/adapters/Prisma/PrismaBaseRepository";
import {
	TagCreateInputInterface,
	TagOutputInterface,
	TagUpdateInputInterface
} from "@/services/Tag/Interfaces/TagInterface";
import {RepositoryQueryInterface} from "@/core/RepositoryQueryInterface";
import {throwIf} from "@/lib/ErrorHandler";
import {PrismaClientKnownRequestError} from "@prisma/client/runtime/library";

/**
 * Resource Model Repository
 *
 */
export default class PostRepository extends PrismaBaseRepository implements RepositoryQueryInterface {
	protected modelName: any | string;
	protected clientModel: any;

	constructor() {
		super();
		this.modelName = "tag"
		this.clientModel = this.client[this.modelName];

		throwIf(
			this.clientModel === undefined,
			`Invalid Client Model (${this.modelName}). Make sure you have properly configured your schema`
		)
	}

	/**
	 * create a new Resource
	 *
	 * @param data
	 */
	async create(data: TagCreateInputInterface) {
		try {
			const resolvedData: TagOutputInterface = await this.clientModel.create({
				data: data
			})

			return Promise.resolve(resolvedData)
		}catch (e: any) {
			// Check if the error is related to a unique constraint violation
			if (e instanceof PrismaClientKnownRequestError && e.code === 'P2002') {
				// Customize the error message for a unique constraint violation
				const errorMessage = `This information already exists.`;
				return Promise.reject(new Error(errorMessage));
			}

			return Promise.reject(e)
		}
	}

	async findById(id: any): Promise<TagOutputInterface> {
		try {
			const resolvedData: TagOutputInterface = await this.clientModel.findFirst({
				where: {id: id}
			})

			return Promise.resolve(resolvedData)
		}catch (e) {
			return Promise.reject(e)
		}
	}

	findByQuery(query: object): any {
		try {
			const resolvedData = {}
			return Promise.resolve(resolvedData)
		}catch (e) {
			return Promise.reject(e)
		}
	}

	getByQuery(query: object): any {
		try {
			const resolvedData = {}
			return Promise.resolve(resolvedData)
		}catch (e) {
			return Promise.reject(e)
		}
	}

	read(id: any): any {
		try {
			const resolvedData = {}
			return Promise.resolve(resolvedData)
		}catch (e) {
			return Promise.reject(e)
		}
	}

	async update(id: number, data: TagUpdateInputInterface): Promise<TagOutputInterface> {
		try {

			data['updatedAt'] = data?.updatedAt ? data.updatedAt : new Date()

			const resolvedData: TagOutputInterface = await this.clientModel.update({
				where: {id: id},
				data: data
			})

			return Promise.resolve(resolvedData)

		}catch (e) {
			return Promise.reject(e)
		}
	}

	async findAll() {
		try {
			const resolvedData: TagOutputInterface[] = await this.clientModel.findMany()

			return Promise.resolve(resolvedData)
		}catch (e) {
			return Promise.reject(e)
		}
	}

	/**
	 * Delete the Resource
	 *
	 * @param id
	 */
	async delete(id: number) {
		try {
			const resolvedData = await this.clientModel.delete({
				where: {id: id}
			})

			return Promise.resolve(resolvedData)
		}catch (e) {
			return Promise.reject(e)
		}
	}
}
