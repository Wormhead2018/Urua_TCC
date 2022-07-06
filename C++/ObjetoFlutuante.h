// Fill out your copyright notice in the Description page of Project Settings.

#pragma once

#include "CoreMinimal.h"
#include "GameFramework/Actor.h"
#include "ObjetoFlutuante.generated.h"

UCLASS()
class URUA_PROJECT_API AObjetoFlutuante : public AActor
{
	GENERATED_BODY()
	
public:	
	// Sets default values for this actor's properties
	AObjetoFlutuante();

protected:
	// Called when the game starts or when spawned
	virtual void BeginPlay() override;

public:	
	// Called every frame
	virtual void Tick(float DeltaTime) override;

private:
	UPROPERTY(EditAnywhere, Category = "Interrocacao")
		class UStaticMeshComponent* MalhaDoAtor;

	
	float TempoExecucao;
	float AlturaDelta;
	FVector NovaLocalizacao;
	
};
