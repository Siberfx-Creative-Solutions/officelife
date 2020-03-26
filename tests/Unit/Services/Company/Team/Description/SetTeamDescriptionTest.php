<?php

namespace Tests\Unit\Services\Company\Team\Description;

use Tests\TestCase;
use App\Jobs\LogTeamAudit;
use App\Models\Company\Team;
use App\Jobs\LogAccountAudit;
use App\Models\Company\Employee;
use Illuminate\Support\Facades\Queue;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Company\Team\Description\SetTeamDescription;

class SetTeamDescriptionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_sets_the_team_description_as_administrator(): void
    {
        $michael = $this->createAdministrator();
        $team = factory(Team::class)->create([
            'company_id' => $michael->company_id,
        ]);
        $this->executeService($michael, $team);
    }

    /** @test */
    public function it_sets_the_team_description_as_hr(): void
    {
        $michael = $this->createHR();
        $team = factory(Team::class)->create([
            'company_id' => $michael->company_id,
        ]);
        $this->executeService($michael, $team);
    }

    /** @test */
    public function it_sets_the_team_description_as_normal_user(): void
    {
        $michael = $this->createEmployee();
        $team = factory(Team::class)->create([
            'company_id' => $michael->company_id,
        ]);
        $this->executeService($michael, $team);
    }

    /** @test */
    public function it_fails_if_the_team_is_not_part_of_the_company(): void
    {
        $michael = $this->createEmployee();
        $team = factory(Team::class)->create([]);

        $this->expectException(ModelNotFoundException::class);
        $this->executeService($michael, $team);
    }

    /** @test */
    public function it_fails_if_wrong_parameters_are_given(): void
    {
        $request = [
            'first_name' => 'Dwight',
        ];

        $this->expectException(ValidationException::class);
        (new SetTeamDescription)->execute($request);
    }

    private function executeService(Employee $michael, Team $team): void
    {
        Queue::fake();

        $request = [
            'company_id' => $michael->company_id,
            'author_id' => $michael->id,
            'team_id' => $team->id,
            'description' => 'This is just great',
        ];

        $team = (new SetTeamDescription)->execute($request);

        $this->assertDatabaseHas('teams', [
            'company_id' => $michael->company_id,
            'id' => $team->id,
            'description' => 'This is just great',
        ]);

        $this->assertInstanceOf(
            Team::class,
            $team
        );

        Queue::assertPushed(LogAccountAudit::class, function ($job) use ($michael, $team) {
            return $job->auditLog['action'] === 'team_description_set' &&
                $job->auditLog['author_id'] === $michael->id &&
                $job->auditLog['objects'] === json_encode([
                    'team_id' => $team->id,
                    'team_name' => $team->name,
                ]);
        });

        Queue::assertPushed(LogTeamAudit::class, function ($job) use ($michael) {
            return $job->auditLog['action'] === 'description_set' &&
                $job->auditLog['author_id'] === $michael->id;
        });
    }
}