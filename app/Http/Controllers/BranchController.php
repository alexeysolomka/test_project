<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Requests\CreateBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Repositories\BranchRepository;
use App\Repositories\MetroRepository;

class BranchController extends Controller
{
    /**
     * @var BranchRepository $branchRepository
     */
    private $branchRepository;
    /**
     * @var MetroRepository $metroRepository
     */
    private $metroRepository;

    public function __construct()
    {
        $this->middleware('auth');
        $this->branchRepository = app(BranchRepository::class);
        $this->metroRepository = app(MetroRepository::class);
    }

    public function index()
    {
        $branches = $this->branchRepository->getAll();

        return view('underground.branch.index', compact('branches'));
    }

    public function create()
    {
        $branch = new Branch;
        $metros = $this->metroRepository->getAll();
        return view('underground.branch.create', compact('branch', 'metros'));
    }

    public function store(CreateBranchRequest $request)
    {
        $createData = $request->all();
        $branch = $this->branchRepository->create($createData);

        if($branch)
        {
            return back()->with('status', 'Branch successful created.');
        }

        return back()->with('error', 'Error to create branch.');
    }

    public function edit($id)
    {
        $branch = Branch::find($id);
        $metros = $this->metroRepository->getAll();

        return view('underground.branch.edit', compact('branch', 'metros'));
    }

    public function update(UpdateBranchRequest $request, $id)
    {
        $updateData = $request->all();
        $branch = $this->branchRepository->update($id, $updateData);

        if($branch)
        {
            return back()->with('status', 'Branch succesful updated.');
        }

        return back()->with('error', 'Error to update branch.');
    }

    public function delete($id)
    {
        $branch = Branch::find($id);

        if($branch->delete())
        {
            return back()->with('status', 'Branch successful deleted.');
        }

        return back()->with('error', 'Error to delete branch');
    }
}
