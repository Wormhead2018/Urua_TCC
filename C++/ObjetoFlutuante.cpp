// Fill out your copyright notice in the Description page of Project Settings.


#include "ObjetoFlutuante.h"
#include "Components/StaticMeshComponent.h"
#include "Engine/EngineTypes.h"


// Sets default values
AObjetoFlutuante::AObjetoFlutuante()
{
 	// Set this actor to call Tick() every frame.  You can turn this off to improve performance if you don't need it.
	PrimaryActorTick.bCanEverTick = true;
	TempoExecucao = 0.0f;
	AlturaDelta = 0.0f;
	NovaLocalizacao = FVector(0.f, 0.f, 0.f);

}

// Called when the game starts or when spawned
void AObjetoFlutuante::BeginPlay()
{
	Super::BeginPlay();

}

// Called every frame
void AObjetoFlutuante::Tick(float DeltaTime)
{
	Super::Tick(DeltaTime);
	NovaLocalizacao = this->GetActorLocation();
	AlturaDelta = (FMath::Sin(TempoExecucao + DeltaTime) - FMath::Sin(TempoExecucao));
	NovaLocalizacao.Z += AlturaDelta * 20.f;
	TempoExecucao += DeltaTime;
	this->SetActorLocation(NovaLocalizacao);
	AddActorLocalRotation(FRotator(0.f, 50.f, 0.f) * DeltaTime);

}

