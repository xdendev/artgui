<?php


namespace Xden\ArtGui\Http\Controllers;


use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Symfony\Component\Console\Command\Command;
use Xden\ArtGui\Contracts\CommandExecutor;
use Xden\ArtGui\Contracts\CommandRepository;
use Xden\ArtGui\Contracts\CommandTransformer;
use Xden\ArtGui\Contracts\CommandValidator;
use Xden\ArtGui\Http\Resources\CommandResource;

class ArtGuiController extends Controller
{
//    use AuthorizesRequests;
//    use ValidatesRequests;

    public function __construct(
        private readonly CommandRepository $repository,
        private readonly CommandTransformer $transformer,
        private readonly CommandExecutor $executor,
        private readonly CommandValidator $validator
    )
    {
    }

    public function index(): View|array
    {
        if (request()->wantsJson()) {
            return array_map(
                fn ($command) => CommandResource::collection($command),
                $this->transformer->prepareCommands($this->repository->getCommands())
            );
        }

        return view('artgui::index');
    }

    public function run(string $command): JsonResponse|RedirectResponse
    {
        $command = $this->validator->findCommandOrFail($command);

        $validatedData = $this->validateCommandInput($command);

        $result = $this->executor->execute($command, $validatedData);

        if (request()->wantsJson()) {
            return response()->json($result->toArray());
        }

        return back()->with($result->toArray());
    }

    private function validateCommandInput(Command $command): array
    {
        $rules = $this->validator->buildRules($command);

        return request()->validate($rules);
    }
}
